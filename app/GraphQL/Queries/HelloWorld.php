<?php

namespace App\GraphQL\Queries;

final class HelloWorld
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        return 'Hello world!';
    }
}
