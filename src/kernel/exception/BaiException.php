<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace baike\framework\exception;

/**
 * Description of exception
 *
 * @author Administrator
 */
class BaiException extends \Exception
{

    private $details = array();

    function __construct($details)
    {
        if (is_array($details)) {
            $message = $details['code'] . ': ' . $details['message'];
            parent::__construct($message);
            $this->details = $details;
        } else {
            $message = $details;
            parent::__construct($message);
        }
    }

    public function getHTTPStatus()
    {
        return isset($this->details['status']) ? $this->details['status'] : '';
    }

    public function getErrorCode()
    {
        return isset($this->details['code']) ? $this->details['code'] : '';
    }

    public function getErrorMessage()
    {
        return isset($this->details['message']) ? $this->details['message'] : '';
    }

    public function getDetails()
    {
        return isset($this->details['body']) ? $this->details['body'] : '';
    }

}
