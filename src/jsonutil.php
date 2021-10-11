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
 * 
 * Based on https://stackoverflow.com/a/10252511/319266
 */

namespace robertsaupe\helper;

/**
 * implements custom json decode with comments support
 */
class jsonutil {

    public static function load( string $filename ):array|false|null {
        $contents = @file_get_contents( $filename );
        if ( $contents === false ) return false;
        return json_decode( self::stripComments( $contents ), true );
    }

    private static function stripComments( string $json ):string|null {

        if (class_exists('robertsaupe\\minify\\json')) {
            return \robertsaupe\minify\json::minify($json);
        } else {
            return preg_replace( '![ \t]*//.*[ \t]*[\r\n]!', '', $json );
        }

    }

}
?>