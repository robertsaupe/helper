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

require_once( dirname(__FILE__) . '/src/FileMgr.php' );

use RobertSaupe\Helper\FileMgr;

print('delete dir test: ');
$result = FileMgr::removeDir('test');
var_dump($result);

print('create dir test/new/newer: ');
$result = FileMgr::createDir('test/new/newer');
var_dump($result);

print('create file test/new/test.txt: ');
$result = file_put_contents('test/new/test.txt', 'new');
var_dump($result);

print('create file test/new/newer/test.txt: ');
$result = file_put_contents('test/new/newer/test.txt', 'new');
var_dump($result);

print('open dir test: ' . PHP_EOL);
FileMgr::openDir('test', callback_file: function($file) {
    print('file: ' . PHP_EOL);
    print_r($file);
}, callback_dir: function($file) {
    print('dir: ' . PHP_EOL);
    print_r($file);
});

print('delete dir test: ');
$result = FileMgr::removeDir('test');
var_dump($result);
?>