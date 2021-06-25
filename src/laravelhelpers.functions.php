<?php

use LaravelHelpers\Translators as Translators;

function hl($key = null, $relation_id = null, $relation = 'systems', $locale = null)
{
    $helpers = new Translators();
    return $helpers->__($key, $relation_id, $relation, $locale);
}
