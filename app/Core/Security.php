<?php

namespace Core;

class Security
{

    public function encryptPassword(string $password): string
    {
        password_hash($password . $_ENV('APP_KEY'), PASSWORD_ARGON2ID, [

        ]);
    }
}