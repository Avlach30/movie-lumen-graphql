<?php

namespace App\GraphQL\Mutations;

use App\Interfaces\AuthInterface;
use App\GraphQL\Types\LoginSuccessResponse;
use App\GraphQL\Types\ResponseError;

final class Login
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */

    protected $authInterface;

    public function __construct(AuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    public function __invoke($_, array $args)
    {
        // TODO implement the resolver

        $email = $args['email'];
        $password = $args['password'];

        $credentials = ['email' => $email, 'password' => $password];

        $expiryTime = auth()->factory()->getTTL() * 60;

        list($token, $error) = $this->authInterface->LogIn($credentials, $expiryTime);
        if ($error != null) {
            return new ResponseError(['message' => $error]);
        }

        return new LoginSuccessResponse([
            'access_token' => $token,
            'type'         => 'bearer jwt',
            'expires_in'   => $expiryTime,
        ]);
    }
}
