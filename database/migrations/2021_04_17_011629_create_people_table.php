<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('gender', ['M', 'F', 'Not Provided', 'Unknown'])->default('Unknown');
            $table->date('dob')->nullable();
            $table->timestamps();
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->foreign('person_id')->references('id')->on('people');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedBigInteger('primary_contact_person_id')->after('id')->nullable();
            $table->foreign('primary_contact_person_id')->references('id')->on('people');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign('people_primary_contact_person_id_foreign');
            $table->dropColumn('primary_contact_person_id');
        });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropForeign('clients_person_id_foreign');
        });

        Schema::dropIfExists('people');
    }
}
