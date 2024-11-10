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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('name');
            $table->string('financier_number')->comment('ممول')->nullable();
            $table->string('age')->comment('العمر')->nullable();
            $table->string('patient_ID')->comment('الهوية')->nullable();
            $table->integer('phone_number1')->comment('جوال 1')->nullable();
            $table->integer('phone_number2')->comment('جوال 2')->nullable();
            $table->string('operation')->comment('العملية')->nullable();
            $table->string('doctor')->comment('الطبيب')->nullable();
            $table->string('anesthesia')->comment('التخدير')->nullable();
            $table->bigInteger('amount')->comment('م مطلوب')->nullable();
            $table->integer('doctor_share')->comment('حصة الطبيب')->nullable();
            $table->integer('anesthesiologists_share')->comment('حصة طبيب التخدير')->nullable();
            $table->integer('bed')->comment('المبيت')->nullable();
            $table->integer('private')->comment('خاص')->nullable();
            $table->boolean('done')->default(0);
            $table->text('notes')->comment('ملاحظات')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
