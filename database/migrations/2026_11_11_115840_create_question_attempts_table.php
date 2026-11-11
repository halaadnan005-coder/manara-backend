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
    Schema::create('question_attempts', function (Blueprint $table) {
        $table->id();

        $table->foreignId('child_id')
              ->constrained('children')
              ->onDelete('cascade');

        $table->foreignId('question_id')
              ->constrained('questions')
              ->onDelete('cascade');

        $table->text('child_answer');
        $table->boolean('is_correct');
        $table->integer('attempt_number');
        $table->timestamp('answered_at');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_attempts');
    }
};
