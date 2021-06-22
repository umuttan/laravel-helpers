<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->string('name');
            $table->string('location')->nullable(true);
            $table->string('icon')->nullable(true);
            $table->enum('rtl', ['Active', 'Passive'])->default('Passive')->comment('Right To Left');
            $table->enum('status', ['Active', 'Passive', 'Hidden'])->default('Active');
            $table->integer('sort')->default('999');
            $table->timestamps();
        });

        $lang_data = [
            "af" => "Afrikaans",
            "ar" => "Arabic",
            "bg" => "Bulgarian",
            "bn" => "Bengali",
            "bo" => "Tibetan",
            "ca" => "Catalan",
            "cs" => "Czech",
            "cy" => "Welsh",
            "da" => "Danish",
            "de" => "German",
            "el" => "Greek",
            "en" => "English",
            "es" => "Spanish",
            "et" => "Estonian",
            "eu" => "Basque",
            "fa" => "Persian",
            "fi" => "Finnish",
            "fj" => "Fiji",
            "fr" => "French",
            "ga" => "Irish",
            "gu" => "Gujarati",
            "he" => "Hebrew",
            "hi" => "Hindi",
            "hr" => "Croatian",
            "hu" => "Hungarian",
            "hy" => "Armenian",
            "id" => "Indonesian",
            "is" => "Icelandic",
            "it" => "Italian",
            "ja" => "Japanese",
            "jw" => "Javanese",
            "ka" => "Georgian",
            "km" => "Cambodian",
            "ko" => "Korean",
            "la" => "Latin",
            "lt" => "Lithuanian",
            "lv" => "Latvian",
            "mi" => "Maori",
            "mk" => "Macedonian",
            "ml" => "Malayalam",
            "mn" => "Mongolian",
            "mr" => "Marathi",
            "ms" => "Malay",
            "mt" => "Maltese",
            "ne" => "Nepali",
            "nl" => "Dutch",
            "no" => "Norwegian",
            "pa" => "Punjabi",
            "pl" => "Polish",
            "pt" => "Portuguese",
            "qu" => "Quechua",
            "ro" => "Romanian",
            "ru" => "Russian",
            "sk" => "Slovak",
            "sl" => "Slovenian",
            "sm" => "Samoan",
            "sq" => "Albanian",
            "sr" => "Serbian",
            "sv" => "Swedish",
            "sw" => "Swahili",
            "ta" => "Tamil",
            "te" => "Telugu",
            "th" => "Thai",
            "to" => "Tonga",
            "tr" => "Turkish",
            "tt" => "Tatar",
            "uk" => "Ukrainian",
            "ur" => "Urdu",
            "uz" => "Uzbek",
            "vi" => "Vietnamese",
            "xh" => "Xhosa",
            "yi" => "Yiddish",
            "zh" => "Chinese"
        ];
        $rightToLeft = ['ar', 'fa', 'he', 'ur', 'yi'];
        foreach ($lang_data as $key => $data) {
            $query = ['code' => $key, 'name' => $data];
            if ($key == 'tr') {
                $query['sort'] = 0;
            } elseif ($key == 'en') {
                $query['sort'] = 1;
            }
            if (in_array($key, $rightToLeft) !== false) $query['rtl'] = 'Active';
            DB::table('languages')->insert($query);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
