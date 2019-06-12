<?php

namespace MattFerris\Hash;

/**
 * Provide a short (truncate) hash of some data
 */
class ShortHash {

    /**
     * @var string The base64 alphabet
     */
    protected $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-';

    /**
     * @var string The data to hash
     */
    protected $data = '';

    /**
     * @var string The hash algorithm to use
     */
    protected $algo = 'sha1';

    /**
     * @var int The length of the resulting hash
     */
    protected $length = 6;


    /**
     * @param string $data The string to hash
     */
    public function __construct($data) {
        $this->data = $data;
    }


    /**
     * Generate a truncated hash
     *
     * @param string $value The value to encode
     * @returns string The encoded string
     */
    public function getHash() {
        $binhash = hash($this->algo, $this->data, true);

        $encoded = '';
        $base16 = unpack('H*', $binhash);
        $base16str = $base16[1];

        $hexbuf = $base16str;
        while (strlen($hexbuf) > 0 && strlen($encoded) < $this->length) {
            $binbuf = '';
            for ($i=0; $i<3; $i++) {
                $binbuf .= base_convert(substr($hexbuf, $i, 1), 16, 2);
            }
            $hexbuf = substr($hexbuf, 3);

            for ($i=0; $i<2; $i++) {
                $dec = base_convert(substr($binbuf, $i, 6), 2, 10);
                $encoded .= $this->alphabet[$dec];
            }
        }

        return $encoded;
    }


    /**
     * @returns string The encoded value
     */
    public function __toString() {
        return $this->getHash();
    }
}

