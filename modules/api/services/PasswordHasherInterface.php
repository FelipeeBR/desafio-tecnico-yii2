<?php

namespace app\modules\api\services;

interface PasswordHasherInterface {
    public function hash(string $password): string;
    public function verify(string $password, string $hash): bool;
}