<?php
/**
 * CSRF token
 *
 * PHP version 5.5
 *
 * @category   OpCacheGUI
 * @package    Security
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 * @copyright  Copyright (c) 2013 Pieter Hordijk <https://github.com/PeeHaa>
 * @license    http://www.opensource.org/licenses/mit-license.html  MIT License
 * @version    1.0.0
 */
namespace OpCacheGUI\Security;

use OpCacheGUI\Storage\KeyValuePair;
use OpCacheGUI\Security\Generator\Builder;
use OpCacheGUI\Security\Generator\UnsupportedAlgorithmException;
use OpCacheGUI\Security\Generator\InvalidLengthException;

/**
 * CSRF token
 *
 * @category   OpCacheGUI
 * @package    Security
 * @author     Pieter Hordijk <info@pieterhordijk.com>
 */
class CsrfToken
{
    /**
     * The length of the tokens
     */
    const LENGTH = 56;

    /**
     * @var \OpCacheGUI\Storage\keyValuePair Instance of a key value storage
     */
    private $storage;

    /**
     * @var \OpCacheGUI\Security\Generator\Builder Instance of a generator builder
     */
    private $factory;

    /**
     * @var array List of supported algorithms sorted by strength (strongest first)
     */
    private $algos = [
        '\\OpCacheGUI\\Security\\Generator\\Mcrypt',
        '\\OpCacheGUI\\Security\\Generator\\OpenSsl',
        '\\OpCacheGUI\\Security\\Generator\\Urandom',
        '\\OpCacheGUI\\Security\\Generator\\MtRand',
    ];

    /**
     * Create sinstance
     *
     * @param \OpCacheGUI\Storage\KeyValuePair       $storage Instance of a key value storage
     * @param \OpCacheGUI\Security\Generator\Builder $factory Instance of a generator builder
     */
    public function __construct(KeyValuePair $storage, Builder $factory)
    {
        $this->storage = $storage;
        $this->factory = $factory;
    }

    /**
     * Adds an algorithm to the list of supported algo's
     *
     * Note: this method will add the new algorithm at teh top of the stack meaning it will be presumed to be stronger
     *       than the default ones!
     *
     * @param string $algo The algo to add to the stack
     */
    public function addAlgo($algo)
    {
        array_unshift($this->algos, $algo);
    }

    /**
     * Gets the stored CSRF token
     *
     * @return string The stored CSRF token
     */
    public function get()
    {
        if (!$this->storage->isKeyValid('csrfToken')) {
            $this->storage->set('csrfToken', $this->generate());
        }

        return $this->storage->get('csrfToken');
    }

    /**
     * Validates the supplied token against the stored token
     *
     * @param string $token The token to validate
     *
     * @return boolean True when the supplied token matches the stored token
     */
    public function validate($token)
    {
        return $token === $this->get();
    }

    /**
     * Generates a new secure CSRF token
     *
     * @return string The generated CSRF token
     */
    private function generate()
    {
        $length = (int) (self::LENGTH * 3 / 4 + 1);
        $buffer = '';

        foreach ($this->algos as $algo) {
            try {
                $generator = $this->factory->build($algo);
            } catch (UnsupportedAlgorithmException $e) {
                continue;
            }

            $buffer .= $generator->generate($length);

            if (strlen($buffer) >= $length) {
                break;
            }
        }

        if (strlen($buffer) < $length) {
            throw new InvalidLengthException(
                'The generated token didn\'t met the required length (`'
                . $length
                . '`). Actual length is: `'
                . strlen($buffer)
                . '`.'
            );
        }

        return str_replace(array('+', '"', '\'', '\\', '/', '=', '?', '&'), '', base64_encode($buffer));
    }
}
