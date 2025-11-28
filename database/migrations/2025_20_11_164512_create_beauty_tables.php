<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('beauty_clients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->unique();
            $table->string('email')->nullable();
            $table->string('alias')->nullable();
            $table->string('document')->unique();
            $table->timestamps();
        });

        Schema::create('beauty_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('duration_minutes');
            $table->decimal('price', 10, 2);
            $table->string('category')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('beauty_staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });

        Schema::create('beauty_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('beauty_clients')->onDelete('cascade');
            $table->dateTime('scheduled_at');
            $table->integer('total_duration_minutes');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled', 'rescheduled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('beauty_appointment_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('beauty_appointments')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('beauty_services')->onDelete('cascade');
            $table->foreignId('staff_id')->nullable()->constrained('beauty_staff')->onDelete('set null');
            $table->timestamps();
        });

        Schema::create('beauty_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('appointment_id')->constrained('beauty_appointments')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['cash', 'transfer', 'nequi', 'other']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('beauty_payments');
        Schema::dropIfExists('beauty_appointment_services');
        Schema::dropIfExists('beauty_appointments');
        Schema::dropIfExists('beauty_staff');
        Schema::dropIfExists('beauty_services');
        Schema::dropIfExists('beauty_clients');
    }
};