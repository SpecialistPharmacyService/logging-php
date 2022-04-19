<?php

namespace makeandship\logging;

const LOG_LEVELS      = ["debug", "info", "error"];
const LOG_LEVEL_DEBUG = "debug";
const LOG_LEVEL_INFO  = "info";
const LOG_LEVEL_ERROR = "error";

const LOG_TIME = 'time';

class Log
{
    public static $timings = array();
    public static function get_log_level()
    {
        if (defined('WP_DEBUG_LOG_LEVEL') && in_array(WP_DEBUG_LOG_LEVEL, LOG_LEVELS)) {
            return WP_DEBUG_LOG_LEVEL;
        } else {
            return "info";
        }
    }

    public static function is_displayed($target_level)
    {
        $current_level = self::get_log_level();

        $index_current_level = array_search($current_level, LOG_LEVELS);
        $index_target_level  = array_search($target_level, LOG_LEVELS);

        return ($index_target_level >= $index_current_level);
    }

    public static function debug($message)
    {
        if (self::is_displayed(LOG_LEVEL_DEBUG)) {
            self::write(LOG_LEVEL_DEBUG, $message);
        }
    }

    public static function info($message)
    {
        if (self::is_displayed(LOG_LEVEL_INFO)) {
            self::write(LOG_LEVEL_INFO, $message);
        }
    }

    public static function error($message)
    {
        if (self::is_displayed(LOG_LEVEL_ERROR)) {
            self::write(LOG_LEVEL_ERROR, $message);
        }
    }

    private static function write($level, $message)
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('[' . strtoupper($level) . '] ' . $message);
        }
    }

    public static function start($name)
    {
        $before               = microtime(true);
        self::$timings[$name] = $before;
    }

    public static function finish($name)
    {
        $before = self::$timings[$name];
        $after  = microtime(true);

        $time = ($after - $before) . " sec/search";

        self::write(LOG_TIME, $name . ' - ' . $time);

        unset(self::$timings[$name]);
    }
}
