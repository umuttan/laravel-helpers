<?php

function __($key = null, $replace = [], $locale = null)
{
    if (is_null($key)) {
        return $key;
    }

    return trans($key, $replace, $locale);
}
