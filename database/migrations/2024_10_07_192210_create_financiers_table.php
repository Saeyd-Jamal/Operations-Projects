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
        Schema::create('financiers', function (Blueprint $table) {
            $table->id();
            $table->string('financier_number');
            $table->string('name');
            $table->string('stage')->nullable();
            $table->string('maneger_name')->nullable();
            $table->decimal('amount_ils', 10, 2)->nullable();
            $table->integer('number_cases')->comment('عدد الحالات')->nullable();
            $table->boolean('completion_project')->comment('إنتهاء المشروع')->default(0);
            $table->boolean('push_project')->comment('دفع المشروع')->default(0);
            $table->boolean('project_distribution')->comment('توزيع المشروع')->default(0);
            $table->boolean('project_archive')->comment('أرشفة المشروع')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financiers');
    }
};
