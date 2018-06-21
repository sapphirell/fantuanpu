<?php

namespace Illuminate\Support\Facades;

/**
 * @see \Illuminate\Redis\Database
 */
class  Redis extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'redis';
    }

    public static function remember($cacheKey,$cacheTime,\Closure $fn)
    {
        return self::hgetall($cacheKey,);
    }

}
