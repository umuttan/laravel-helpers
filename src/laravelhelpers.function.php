<?php

use LaravelHelpers\Helpers as Helpers;

function hl($key = null, $model_id = null, $model = 'systems', $locale = null)
{
    $helpers = new Helpers();
    return $helpers->__($key, $model_id, $model, $locale);
}
