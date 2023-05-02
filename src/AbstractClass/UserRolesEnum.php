<?php

namespace App\AbstractClass;


abstract class UserRolesEnum
{
    static array $roles = [
        'ROLE_USER' => 'ROLE_USER',
        'ROLE_ADMIN' => 'ROLE_ADMIN',
        'ROLE_COMPTABLE' => 'ROLE_COMPTABLE'
    ];
}