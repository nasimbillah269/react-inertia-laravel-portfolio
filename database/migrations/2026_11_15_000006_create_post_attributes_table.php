<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * `post_attributes` table — generated from the live database schema.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_attributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('src_id')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('reff_id')->nullable();
            $table->text('sku_id')->nullable();
            $table->boolean('type')->default(0)->comment('0=Category Post, 1=blog Category Post, 2=Blog Tags post, 3=Product Attribute post 4= Product Tags Post, 5=Coupon category Post, 6=Coupon product Post, 7=Product Variation Attributes ,8=Product Variation Attributes Items, 9=Product Variation Attributes Item Value');
            $table->string('status', 20)->nullable();
            $table->float('reguler_price')->default(0.00);
            $table->float('discount')->default(0.00);
            $table->string('discount_type', 10)->default('percent')->comment('percent, flat');
            $table->float('final_price')->default(0.00);
            $table->float('purchase_price')->default(0.00);
            $table->float('wholesale_price')->default(0.00);
            $table->integer('quantity')->default(0);
            $table->boolean('stock_status')->default(1);
            $table->integer('duration')->nullable();
            $table->integer('stock')->default(0);
            $table->string('value_1', 100)->nullable();
            $table->string('barcode', 100)->nullable();
            $table->bigInteger('drag')->nullable();
            $table->bigInteger('addedby_id')->nullable();
            $table->timestamps();
        });

        // exact FLOAT columns (Blueprint::float() would create DOUBLE(8,2) on Laravel 10)
        DB::statement('ALTER TABLE `post_attributes` MODIFY `reguler_price` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `post_attributes` MODIFY `discount` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `post_attributes` MODIFY `final_price` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `post_attributes` MODIFY `purchase_price` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `post_attributes` MODIFY `wholesale_price` FLOAT(10,2) NOT NULL DEFAULT 0.00');
    }

    public function down(): void
    {
        Schema::dropIfExists('post_attributes');
    }
};
