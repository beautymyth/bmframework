<?php

namespace Framework\Facade;

use Framework\Service\Auth\User as UserService;

/**
 * @method static bool check()
 * @method static string getUserId()
 * @method static string getUserName()
 *
 * @see \Framework\Service\Auth\User
 */
class User extends Facade {

    /**
     * 获取外观名称
     */
    protected static function getFacadeAccessor() {
        return UserService::class;
    }

}
