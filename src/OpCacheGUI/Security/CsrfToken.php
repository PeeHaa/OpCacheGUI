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
     * Gets the stored CSRF token
     *
     * @return string The stored CSRF token
     */
    public function get()
    {
        if (!array_key_exists('csrfToken', $_SESSION)) {
            $_SESSION['csrfToken'] = $this->generate();
        }

        return $_SESSION['csrfToken'];
    }

    /**
     * Validates the supplied token against the stored token
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
     * @param int $rawLength The (raw) length of the token to be generated
     *
     * @return string The generated CSRF token
     */
    private function generate()
    {
        $length = 56;
        $token = '';
        if (function_exists('mcrypt_create_iv')) {
            $token = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $token = openssl_random_pseudo_bytes($length);
        } elseif (file_exists('/dev/urandom')) {
            $fileHandle = @fopen('/dev/urandom', 'r');
            if ($fileHandle) {
                $read = 0;
                while ($read < $length) {
                    $token .= fread($fileHandle, $length - $read);
                    $read = strlen($token);
                }
                fclose($fileHandle);
            }
        } elseif (strlen($token) < $length) {
            for ($i = strlen($token); $i < $length; $i++) {
                $token .= chr(mt_rand(0, 255));
            }
        }

        return str_replace(array('+', '"', '\'', '\\', '/', '=', '?', '&'), '', base64_encode($token));
    }
}
