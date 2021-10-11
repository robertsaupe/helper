<?php
/**
 * phpHelper
 * 
 * Please report bugs on https://github.com/robertsaupe/phphelper/issues
 *
 * @author Robert Saupe <mail@robertsaupe.de>
 * @copyright Copyright (c) 2018, Robert Saupe. All rights reserved
 * @link https://github.com/robertsaupe/phphelper
 * @license MIT License
 */

namespace robertsaupe\helper;

/**
 * some time functions
 */
class time {

    public const FORMAT_SHORT = 'Y-m-d';
    public const FORMAT_LONG = 'Y-m-d_H-i-s';

    private static string $format = self::FORMAT_LONG;

    /**
     * set format for date
     *
     * @param string $format
     * @return bool
     */
    public static function set_format(string $format):bool {
        if ($format == '') return false;
        self::$format = $format;
        return true;
    }

    /**
     * get format for date
     *
     * @param string $format
     * @return bool
     */
    public static function get_format():string {
        return self::$format;
    }

    /**
     * get formatted date
     *
     * @param integer|null $timestamp
     * @return string
     */
    public static function get_formatted_date(?int $timestamp = null):string {
        if ($timestamp == null) $timestamp = time();
        return date(self::$format, $timestamp);
    }

    /**
     * set timezone
     *
     * @param string|null $timezone
     * @return bool
     */
    public static function set_zone(?string $timezone = null):bool {
        if ( $timezone != null && $timezone != '' ) return date_default_timezone_set($timezone);
        else return false;
    }

    /**
     * get timezone
     *
     * @return string
     */
    public static function get_zone():string {
        return date_default_timezone_get();
    }

}