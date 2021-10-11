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

class rest {

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';

    private string|false $result = false;

    private array $context = array();

    public function __construct(
        private string $url,
        private array $data,
        private string $method = self::METHOD_GET,
        private bool $ignore_ssl_cert = false
        ) {
            if ($this->ignore_ssl_cert == true) {
                $this->context['ssl'] = ['verify_peer' => false, 'verify_peer_name' => false];
            }
            $this->context['http'] = ['method'  => $this->method, 'header'  => 'Content-type: application/x-www-form-urlencoded', 'content' => http_build_query($this->data)];
            $this->result = file_get_contents($this->url, false, stream_context_create($this->context));
    }

    public function get_raw():string|false {
        return $this->result;
    }

    public function get_json():null|array {
        return json_decode($this->result, true);
    }

}