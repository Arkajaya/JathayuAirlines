<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Roles table (only create if missing)
        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        // Users table sudah ada dari Breeze, kita tambah role_id jika belum ada
        if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('role_id')->default(3)->constrained('roles');
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->date('birth_date')->nullable();
            });
        }

        // Services table (penerbangan)
        if (! Schema::hasTable('services')) {
            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->string('flight_number')->unique();
                $table->string('airline_name');
                $table->string('departure_city');
                $table->string('arrival_city');
                $table->dateTime('departure_time');
                $table->dateTime('arrival_time');
                $table->integer('duration'); // dalam menit
                $table->integer('capacity');
                $table->integer('booked_seats')->default(0);
                $table->decimal('price', 10, 2);
                $table->enum('class', ['economy', 'business', 'first']);
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // Bookings table
        if (! Schema::hasTable('bookings')) {
            Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code')->unique();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->integer('passenger_count');
            $table->json('passenger_details'); // nama, tanggal lahir, passport
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'completed'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->text('special_request')->nullable();
            $table->boolean('is_checkin')->default(false);
            $table->timestamps();
            });
        }

        // Cancellations table
        if (! Schema::hasTable('cancellations')) {
            Schema::create('cancellations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->text('reason');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->decimal('refund_amount', 10, 2)->nullable();
            $table->timestamps();
            });
        }

        // Blogs table
        if (! Schema::hasTable('blogs')) {
            Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->string('author');
            $table->integer('views')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
            });
        }

        // Activity logs table
        if (! Schema::hasTable('activity_logs')) {
            Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->string('action');
            $table->text('description');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('cancellations');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('services');
        Schema::dropIfExists('blogs');
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['role_id']);
                $table->dropColumn(['role_id', 'phone', 'address', 'birth_date']);
            });
        }
        Schema::dropIfExists('roles');
    }
};