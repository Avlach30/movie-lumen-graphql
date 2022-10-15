<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\User;

class AuthRepository implements AuthInterface
{
    public function SignUp(User $user)
    {   
        try {
            $newUser = $user->save();
            return [$user, null];
        } catch (\Exception $exception) {
            return [$user, 'Save new user when sign up failed'];
        }
    }

    public function FindUserByEmail($email)
    {
        $isExist = User::where('email', $email)->first();
        if ($isExist) {
            return true;
        }

        return false;
    }

    public function LogIn(array $credentials, $expiryTime)
    {   
        $token = auth()->attempt($credentials);
        if (gettype($token) != "string") {
            return [$token, 'Invalid email or password'];
        }

        return [$token, null];
    }
}
