<?php

namespace Controllers;

class BaseController
{
    protected function redirect() {
        echo 'Redirect!';
    }

    protected function sanitize(string $string): string{
        if (!$this->isNonEmptyStr($string)){
            return $string;
        }
//        echo 'without filters: '. $string . '<br>';
//        $string = filter_var($string,  FILTER_SANITIZE_STRING);
        $string = str_replace('(', '', $string);
        $string = str_replace(')', '', $string);
        $string = str_replace('*', '', $string);
        $string = str_replace('"', '', $string);
        $string = str_replace("'", '', $string);
//        echo 'with filters: '. $string . '<br>';
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

    protected function sanitizeArray(array $array_to_clean): array {
        foreach ($array_to_clean as $field_value) {
            $cleaned_array[] = $this->sanitize($field_value);
        }
        return $cleaned_array;
    }
}