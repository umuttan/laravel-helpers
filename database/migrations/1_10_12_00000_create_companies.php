<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url')->nullable(true);
            $table->string('apikey')->nullable(true);
            $table->string('contact_name')->nullable(true);
            $table->string('contact_phone')->nullable(true);
            $table->string('contact_mail')->nullable(true);
            $table->string('contact_address')->nullable(true);
            $table->string('tax_office')->nullable(true);
            $table->string('tax_no')->nullable(true);
            $table->integer('package_id')->nullable(true);
            $table->dateTime('passive_since')->nullable(true);
            $table->string('lang_code')->nullable(false)->default('tr');
            $table->enum('status', ['Active', 'Passive', 'Hidden'])->default('Active');
            $table->timestamps();
        });
        DB::table('companies')->insert(['id' => 1, 'name' => 'Admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
