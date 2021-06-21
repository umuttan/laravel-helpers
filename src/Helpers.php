<?php

namespace LaravelHelpers {

    class Helpers
    {
        public function __($key, $lang_code)
        {
            echo json_encode([$key, $lang_code]);
            return $key;
        }
    }
}


