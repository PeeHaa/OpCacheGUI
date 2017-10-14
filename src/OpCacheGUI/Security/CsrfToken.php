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
     * Creates instance
     *
     * @param \OpCacheGUI\Storage\KeyValuePair $storage Instance of a key value storage
     */
    public function __construct(KeyValuePair $storage)
    {
        $this->storage = $storage;
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
     * @throws InsufficientRandomData
     */
    private function generate()
    {
        try {
            $token = random_bytes(self::LENGTH);
        } catch (\Throwable $e) {
            throw new InsufficientRandomData($e->getMessage(), $e->getCode(), $e);
        }

        return bin2hex($token);
    }
}
