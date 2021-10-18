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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('subscription_id');
            $table->enum('status', ['Free', 'Premium']);
            $table->unsignedBigInteger('admin_id');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('stopped_at')->nullable();
            $table->timestamps();
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
            $table->foreign('subscription_id')
                  ->references('id')->on('subscriptions')
                  ->onDelete('cascade');
            $table->foreign('admin_id')
                  ->references('id')->on('admins')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscribers');
    }
}
