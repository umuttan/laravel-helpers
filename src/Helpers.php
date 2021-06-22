<?php

namespace LaravelHelpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class Helpers
{
    protected $company_id, $lang_code;

    public function __construct()
    {
        $this->company_id = session()->get('company_id');
        $this->lang_code = App::currentLocale();
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    function __($key = null, $model_id = null, $model = 'systems', $locale = null)
    {
        $company_id = $this->company_id;
        if (is_null($company_id) || $model == 'systems') $company_id = 1;
        if (is_null($locale)) $locale = $this->lang_code;
        return $this->getLang($key, $model_id, $model, $company_id, $locale);
    }

    private function getLang($key, $model_id, $model, $company_id, $code)
    {
        if (is_null($model_id)) $model_id = md5($key);
        $lang_var = DB::table('language_values')->where([
            'model_id' => $model_id,
            'model' => $model,
            'company_id' => $company_id,
            'code' => $code
        ])->first();

        if (!empty($lang_var->value)) return $lang_var->value;

        $this->setLang($key, $model_id, $model, $company_id, $code);
        return $key;
    }

    private function setLang($key, $model_id, $model, $company_id, $code)
    {
        return DB::table('language_values')->insert([
            'company_id' => $company_id,
            'code' => $code,
            'model' => $model,
            'model_id' => $model_id,
            'value' => $key,
        ]);
    }
}
