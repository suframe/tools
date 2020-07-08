<?php
namespace suframe\tools\easemob;

class Cache
{

    protected static $instance;

    public static function init($cache)
    {
        self::$instance  = $cache;
    }
    
    public static function set($key, $value, $ttl = null)
    {
        return self::$instance->set($key, $value, $ttl);
    }

    public static function has($key)
    {
        return self::$instance->has($key);
    }

    public static function get($key, $default = null)
    {
        return self::$instance->get($key, $default);
    }

    public static function delete($key)
    {
        return self::$instance->delete($key);
    }

}
