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

    public static function String($string):string {
        $string = trim($string);
        $string = htmlentities($string);
        return $string;
    }

    public static function Array(array $array):array {
        $array = array_map('trim', $array);
        $array = array_map('htmlentities', $array);
        return $array;
    }

    //superglobals
    //$GLOBALS, $_SERVER, $_GET, $_POST, $_FILES, $_COOKIE, $_SESSION, $_REQUEST, $_ENV

    /**
     * clean input superglobals ($_GET, $_POST, $_FILES) and make it valid
     *
     * @return void
     */
    public static function Input() {
        if (isset($_GET)) $_GET = self::Array($_GET);
        if (isset($_POST)) $_POST = self::Array($_POST);
        if (isset($_FILES)) $_FILES = array_map('self::Array', $_FILES);
    }

}
?>