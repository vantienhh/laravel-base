<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->string('phone')->nullable();
            $table->bigInteger('contact_id')->unsigned()->index();
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');;
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscribers', function($table)
        {
            $table->dropForeign('subscribers_contact_id_foreign');
            $table->dropIndex('subscribers_contact_id_index');
            $table->dropColumn('contact_id');
        });
        Schema::dropIfExists('subscribers');
    }
}
