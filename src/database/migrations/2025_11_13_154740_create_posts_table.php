<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();

            // Category (apartment, land, house…)
            $table->foreignId('category_id')->nullable()->constrained();

            // Property info
            $table->enum('property_type', ['house','apartment','land','room','office','other']);
            $table->enum('transaction_type', ['sell','rent','auction']);

            $table->decimal('price', 15, 2)->nullable();
            $table->enum('price_unit', ['vnđ','triệu','tỷ','thoả thuận'])->default('vnđ');

            $table->decimal('area', 10, 2)->nullable();
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('floors')->nullable();

            $table->string('direction')->nullable();

            // Location
            $table->string('address')->nullable();
            $table->string('province')->nullable();
            $table->string('district')->nullable();
            $table->string('ward')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            // Status
            $table->enum('status', ['pending','approved','rejected','sold','rented','closed'])
                  ->default('pending');
            $table->integer('views')->default(0);
            $table->boolean('is_featured')->default(false);

            // Auction
            $table->boolean('is_auction')->default(false);
            $table->decimal('auction_start_price', 15, 2)->nullable();
            $table->decimal('auction_deposit_price', 15, 2)->nullable();
            $table->decimal('auction_step', 15, 2)->nullable();
            $table->dateTime('auction_start_time')->nullable();
            $table->dateTime('auction_end_time')->nullable();
            $table->enum('auction_status', ['upcoming','ongoing','ended','cancelled'])->nullable();
            $table->unsignedBigInteger('auction_winner_id')->nullable();
            $table->decimal('current_bid_price', 15, 2)->nullable();

            $table->timestamp('published_at')->nullable();
            $table->timestamp('expires_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
