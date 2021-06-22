<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyLanguages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_languages', function (Blueprint $table) {
            $table->string('code');
            $table->foreign('code')->references('code')->on('languages')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unsignedBigInteger('company_id')->nullable(true);
            $table->foreign('company_id')->references('id')->on('companies')->cascadeOnDelete()->cascadeOnUpdate();
            $table->enum('status', ['Active', 'Passive', 'Hidden'])->default('Active');
            $table->integer('sort')->default('0');
            $table->timestamps();
            $table->primary(['code', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_languages');
    }
}
