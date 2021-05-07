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

namespace RobertSaupe\Helper;

class Clean {

    private static function trim($element) {
        if (is_array($element)) return array_map('self::trim', $element);
        else if (is_string($element)) return trim($element);
        else return $element;
    }

    private static function htmlentities($element) {
        if (is_array($element)) return array_map('self::htmlentities', $element);
        else if (is_string($element)) return htmlentities($element);
        else return $element;
    }

    public static function string($string):string {
        $string = trim($string);
        $string = htmlentities($string);
        return $string;
    }

    public static function array(array $array):array {
        $array = array_map('self::trim', $array);
        $array = array_map('self::htmlentities', $array);
        return $array;
    }

    //superglobals
    //$GLOBALS, $_SERVER, $_GET, $_POST, $_FILES, $_COOKIE, $_SESSION, $_REQUEST, $_ENV

    /**
     * clean input superglobals ($_GET, $_POST, $_FILES) and make it valid
     *
     * @return void
     */
    public static function input() {
        if (isset($_GET)) $_GET = self::array($_GET);
        if (isset($_POST)) $_POST = self::array($_POST);
        if (isset($_FILES)) $_FILES = self::array($_FILES);
    }

}
?>