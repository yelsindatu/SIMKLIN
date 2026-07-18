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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('diagnosis_id')->nullable()->constrained('diagnoses')->onDelete('set null');
            $table->string('blood_pressure')->nullable();
            $table->decimal('temperature', 5, 2)->nullable();
            $table->text('symptoms')->nullable();
            $table->text('physical_exam')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->enum('status', ['draft', 'locked'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
