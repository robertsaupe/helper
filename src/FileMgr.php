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

class FileMgr {

    /**
     * get extension of a file
     *
     * @param string|null $filename
     * @return string
     */
    public static function getExtension(?string $filename = null):string {
        $filename = basename($filename);
        if ($filename == null) return '';
        if (mb_strrpos($filename, '.') !== false) return strtolower(mb_substr($filename, mb_strrpos($filename, '.') + 1));
        else return '';
    }

    /**
     * get filename without extension
     *
     * @param string|null $filename
     * @return string
     */
    public static function getName(?string $filename = null):string {
        $filename = basename($filename);
        if ($filename == null) return '';
        $undefined = mb_strpos($filename, '?');
        if ($undefined !== false) $filename = mb_substr($filename, 0, $undefined);
        $dot = mb_strrpos($filename, '.');
        if ($dot !== false) return mb_substr($filename, 0, $dot);
        else return $filename;
    }

    /**
     * chmod a file
     * return bool on success/failure or null if not exists or not readable
     * 
     * @param string $file
     * @param int|string $mode
     * @return null|bool
     */
    public static function chmod(string $file, int|string $mode = '0755'):null|bool {
        if (!file_exists($file) || !is_readable($file)) return null;
        if (is_string($mode) && strlen($mode) == 4) return @chmod($file, @octdec($mode));
        else if (is_int($mode)) return @chmod($file, $mode);
        else return false;
    }

    /**
     * get Dirname without ending slash or backslash
     *
     * @param string $dir
     * @return string
     */
    public static function dirname(string $dir):string {
        $dir = str_replace("\\", "/", $dir);
        if (strlen($dir) > 1 && (mb_substr($dir, -1) == '/')) $dir = mb_substr($dir, 0, -1);
        return $dir;
    }

    /**
     * create a directory
     * return bool on success/failure or null if already exists
     * 
     * @param string $dir
     * @param int|string $mode
     * @param bool $recursive
     * @return null|bool
     */
    public static function createDir(string $dir, int|string $mode = '0755', bool $recursive = true):null|bool {
        if (is_dir($dir)) return null;
        if (is_string($mode) && strlen($mode) == 4) return @mkdir($dir, @octdec($mode), $recursive);
        else if (is_int($mode)) return @mkdir($dir, $mode, $recursive);
        else return false;
	}

    /**
     * open a directory
     * 
     * use callback functions to make some with files or dirs
     *
     * @param string $dir
     * @param array|null $excludes
     * @param boolean $recursive
     * @param string|null $basedir
     * @param object|null $callback_file
     * @param object|null $callback_dir
     * @return void
     */
    public static function openDir(string $dir, ?array $excludes = null, bool $recursive = true, ?string $basedir = null, ?object $callback_file = null, ?object $callback_dir = null) {
        $dir = self::dirname($dir);
        if ($basedir == null) $basedir = $dir;
        if (!is_dir($dir)) return;
        $filelist = scandir($dir);

        foreach($filelist as $file) {
            if ($file == '.' || $file == '..') continue;
            $file_path = ($dir == '/' ? '' : $dir) . '/' . $file;

            if ($excludes !== null) {
                foreach ($excludes as $exclude) {
                    if (strlen($exclude) < 2) continue;
                    if ($exclude[0] == '/' && strpos($file_path, $exclude) === 0) continue 2;
                    if ($exclude[0] != '/' && strpos($file_path, $exclude) !== false) continue 2;
                }
            }

            $file_obj = new \stdClass;
            $file_obj->fullname = $file;
            $file_obj->path = $file_path;
            $file_obj->dir = $dir;
            $file_obj->basedir = $basedir;
            $file_obj->cleandir = substr($dir, strlen($basedir) + 1);
            $file_obj->cleanfile = $file_obj->cleandir . ((strlen($file_obj->cleandir) > 0) ? '/' : '') . $file;

            if (is_dir($file_path)) {
                $file_obj->typ = 'dir';
                if ($recursive) self::openDir($file_path, $excludes, $recursive, $basedir, $callback_file, $callback_dir);
                if ($callback_dir !== null) $callback_dir($file_obj);
                continue;
            }

            $file_obj->typ = 'file';
            $file_obj->name = self::getName($file);
            $file_obj->ext = self::getExtension($file);

            $callback_file($file_obj);
            
        }

    }

    /**
     * remove a directory
     * return bool on success/failure or null if not exists or not readable
     *
     * @param string $dir
     * @param boolean $recursive
     * @return null|bool
     */
    public static function removeDir(string $dir, bool $recursive = true):null|bool {
        if (!is_dir($dir)) return null;
        if (!$recursive) return @rmdir($dir);
        self::openDir($dir, callback_file: function($file) {
            @unlink($file->path);
        }, callback_dir: function($file) {
            @rmdir($file->path);
        });
        return @rmdir($dir);
    }

}
?>