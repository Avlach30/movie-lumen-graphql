<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthInterface
{

    public function SignUp(User $user);

    public function FindUserByEmail($email);

    public function LogIn(array $credentials, $expirytime);
}