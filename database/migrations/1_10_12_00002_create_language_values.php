<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguageValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_values', function (Blueprint $table) {
            $table->string('code');
            $table->foreign('code')->references('code')->on('languages')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('model')->nullable(true);
            $table->foreign('model')->references('prefix')->on('models')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('model_id')->nullable(false);
            $table->unsignedBigInteger('company_id')->nullable(true);
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->longText('value')->nullable(false);
            $table->timestamps();
            $table->primary(['code', 'model', 'model_id', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_values');
    }
}
