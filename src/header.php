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

class header {

    public static function access_control_allow_origin(string $origin) {
        if (!headers_sent()) {
            header('Access-Control-Allow-Origin: '. $origin, true);
        }
    }

}