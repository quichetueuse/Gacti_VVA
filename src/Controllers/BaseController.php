<?php

namespace Controllers;

class BaseController
{

    protected function sanitize(string $string): string{
        if (!$this->isNonEmptyStr($string)){
            return $string;
        }
        $string = str_replace('"', '', $string);
        $string = str_replace("'", '', $string);
        return $string;
    }

    protected function isNonEmptyStr(string $var): bool
    {
        if(isset($var)) {
            if(is_string($var)) {
                if(strlen($var) > 0) {
                    return true;
                }
            }
        }
        return false;
    }
}