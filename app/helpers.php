<?php

if (!function_exists("mbi_secretkey")) {
    function mbi_secretkey()
    {
        static $key;
        if (env('APP_ENV') === 'local' || env('APP_ENV') === 'testing') {
            return 'd!k3$txxxTExtt1AK@aaaO1233456ddAej%&wDdk#';
        }
        if (is_null($key)) {
            $fp = fopen(env('PATH_MBI_SECRETKEY_INI', '/home/secret/mbi_secretkey.ini'), 'r');
            if ($fp === false) {
                return null;
            }
            $content = fread($fp, filesize(env('PATH_MBI_SECRETKEY_INI', '/home/secret/mbi_secretkey.ini')));

            $key = 'ENCRYPT_KEY_CONFIG=';
            $start = strpos($content, $key) + strlen($key);
            $end = strpos($content, "\n", $start);
            $length = ($end ?: strlen($start)) - $start;
            $key = substr($content, $start, $length);
        }
        return $key;
    }
}

if (!function_exists("mbi_decrypt")) {
    function mbi_decrypt(string $encrypted)
    {
        return openssl_decrypt(base64_decode($encrypted), 'aes-256-cbc', mbi_secretkey(), true, str_repeat(chr(0), 16));
    }
}

if (!function_exists("mbi_encrypt")) {
    function mbi_encrypt(string $plain)
    {
        return base64_encode(openssl_encrypt($plain, 'aes-256-cbc', mbi_secretkey(), true, str_repeat(chr(0), 16)));
    }
}

?>