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

class Check {

    public static function isSSL():bool {
        if( !empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ) return true;
        else if( !empty( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) return true;
        else return false;
    }

    public static function isMail(string $mail):bool {
        if (preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $mail)) return true; else return false;
    }

    public static function isText(string $text):bool {
        if (preg_match('/[^a-zA-Z0-9._-]/i',$text)) return false; else return true;
    }

    public static function implements_class_interface(string $class_name, string $interface_name):bool {
        $interfaces = class_implements( $class_name );
        return isset($interfaces[$interface_name]) ? true : false ;
    }

}
?>