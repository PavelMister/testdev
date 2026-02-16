<?php

namespace Core;

class Security
{

    /**
     * Encrypting string by app_key, using argon2id algorithm)
     * @param string $password
     * @return string
     */
    public function encryptPassword(string $password): string
    {
        return password_hash($password . $_ENV('APP_KEY'), PASSWORD_ARGON2ID);
    }
}