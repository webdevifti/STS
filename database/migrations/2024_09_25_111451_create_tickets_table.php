<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_number')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->integer('category_id')->nullable();
            $table->string('title')->nullable();
            $table->longText('message')->nullable();
            $table->string('labels')->nullable();
            $table->text('files_attachments')->nullable();
            $table->string('priority')->nullable();
            $table->string('status')->default('opened');
            $table->timestamps();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
