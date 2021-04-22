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

/**
 * implements custom json decode with comments support
 */
class JsonUtil {

    /**
     * From https://stackoverflow.com/a/10252511/319266
     * @return array|false|null
     */
    public static function Load( $filename ):array|false|null {
        $contents = @file_get_contents( $filename );
        if ( $contents === false ) return false;
        return json_decode( self::stripComments( $contents ), true );
    }

    /**
     * From https://stackoverflow.com/a/10252511/319266
     * @param string $str
     * @return string
     */
    private static function stripComments( $str ) {
        return preg_replace( '![ \t]*//.*[ \t]*[\r\n]!', '', $str );
    }

}
?>