<?php

namespace LaravelHelpers;


use \Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\ErrorHandler\Debug;

class Translators
{
    protected $company_id, $lang_code;

    public function __construct()
    {
        $this->company_id = session()->get('company_id');
        if (request('_lang')) session()->put('locale', request('_lang'));
        if (session('locale')) App::setLocale(session('locale'));
        $this->lang_code = App::currentLocale();
    }

    public function boot()
    {
        //$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    function __($key = null, $relation_id = null, $relation = 'systems', $locale = null)
    {
        $company_id = $this->company_id;
        if (is_null($company_id) || $relation == 'systems') $company_id = 1;
        if (is_null($locale)) $locale = $this->lang_code;
        return $this->getLang($key, $relation_id, $relation, $company_id, $locale);
    }

    private function getLang($key, $relation_id, $relation, $company_id, $code)
    {
        if (is_null($relation_id)) $relation_id = md5($key);
        $main_prefix = $this->prefixLang($relation_id, $relation, $code, 1 /*Main Store*/);
        $prefix = $this->prefixLang($relation_id, $relation, $code, $company_id);
        if (empty($lang_var = Cache::get('language_values'))) {
            $lang_var = DB::table('language_values')->get([
                '*',
                DB::raw('CONCAT(code,\'_\',relation,\'_\',relation_id,\'_\',company_id) AS prefix')
            ])->keyBy('prefix');
            Cache::add('language_values', $lang_var);
            $lang_var = $lang_var->toArray();
        }
        if (!isset($lang_var[$prefix]) && isset($lang_var[$main_prefix])) $lang_var[$prefix] = $lang_var[$main_prefix];
        if (isset($lang_var[$prefix])) return $lang_var[$prefix]->value;
        dd($lang_var, $prefix);
        $this->setLang($key, $relation_id, $relation, $company_id, $code);

        return $key;
    }

    private function setLang($key, $relation_id, $relation, $company_id, $code)
    {
        $prefix = $this->prefixLang($relation_id, $relation, $code, $company_id);
        $_data = [
            'company_id' => $company_id,
            'code' => $code,
            'relation' => $relation,
            'relation_id' => $relation_id,
            'value' => $key,
        ];
        if (!empty($lang_var = Cache::get('language_values'))) {
            $lang_var[$prefix] = (object)$_data;
        }
        return DB::table('language_values')->insert($_data);
    }

    private function prefixLang($relation_id, $relation, $code, $company_id)
    {
        return $code . '_' . $relation . '_' . $relation_id . '_' . $company_id;
    }
}
