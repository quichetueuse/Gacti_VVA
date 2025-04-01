<?php

namespace Controllers;

class BaseController
{
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