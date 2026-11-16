<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * `posts` table — generated from the live database schema.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->string('slug', 250)->nullable();
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('sku_code', 100)->nullable();
            $table->string('bar_code', 100)->nullable();
            $table->integer('stock_out_limit')->default(0);
            $table->boolean('stock_status')->default(1);
            $table->boolean('final_stock_status')->default(1);
            $table->integer('quantity')->nullable();
            $table->float('purchase_price')->default(0.00);
            $table->float('wholesale_price')->default(0.00);
            $table->float('final_price')->default(0.00);
            $table->float('pos_price')->default(0.00);
            $table->float('discount')->default(0.00);
            $table->string('discount_type', 20)->nullable();
            $table->float('regular_price')->default(0.00);
            $table->float('min_price')->default(0.00);
            $table->float('max_price')->default(0.00);
            $table->timestamp('offer_start_date')->nullable();
            $table->timestamp('offer_end_date')->nullable();
            $table->integer('min_order_quantity')->default(1);
            $table->integer('max_order_quantity')->nullable();
            $table->string('weight_unit', 100)->nullable();
            $table->string('weight_amount', 50)->nullable();
            $table->string('dimensions_unit', 100)->nullable();
            $table->string('dimensions_length', 50)->nullable();
            $table->string('dimensions_width', 50)->nullable();
            $table->string('dimensions_height', 50)->nullable();
            $table->text('warranty_note')->nullable();
            $table->float('warranty_charge')->default(0.00);
            $table->string('warranty_note2', 100)->nullable();
            $table->float('warranty_charge2')->default(0.00);
            $table->boolean('variation_status')->default(0);
            $table->string('video_link', 200)->nullable();
            $table->boolean('pos_status')->default(0);
            $table->boolean('emi_status')->default(0);
            $table->boolean('digital_status')->default(0);
            $table->boolean('classified_status')->default(0);
            $table->string('product_source', 50)->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('subbrand_id')->nullable();
            $table->integer('sell_count')->default(0);
            $table->integer('branch_count')->default(0);
            $table->boolean('product_type')->default(0);
            $table->text('tags')->nullable();
            $table->unsignedBigInteger('view')->default(0);
            $table->integer('type')->default(0)->comment('0=Page,1=Post, 2=Product');
            $table->string('seo_title', 191)->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keyword')->nullable();
            $table->string('template', 100)->nullable();
            $table->text('search_key')->nullable();
            $table->string('status', 10)->default('temp')->comment('temp,active,inactive');
            $table->boolean('for_website')->default(0);
            $table->boolean('new_arrival')->default(0);
            $table->boolean('fetured')->default(0);
            $table->boolean('top_sale')->default(0);
            $table->boolean('sale_label')->default(0);
            $table->boolean('import_status')->default(0);
            $table->bigInteger('addedby_id')->nullable();
            $table->bigInteger('editedby_id')->nullable();
            $table->timestamps();
            $table->index('brand_id', 'brand_id');
            $table->index('final_price', 'final_price');
            $table->index('name', 'name');
            $table->index('regular_price', 'regular_price');
            $table->index('slug', 'slug');
        });

        // exact FLOAT columns (Blueprint::float() would create DOUBLE(8,2) on Laravel 10)
        DB::statement('ALTER TABLE `posts` MODIFY `purchase_price` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `posts` MODIFY `wholesale_price` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `posts` MODIFY `final_price` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `posts` MODIFY `pos_price` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `posts` MODIFY `discount` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `posts` MODIFY `regular_price` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `posts` MODIFY `min_price` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `posts` MODIFY `max_price` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `posts` MODIFY `warranty_charge` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `posts` MODIFY `warranty_charge2` FLOAT(10,2) NOT NULL DEFAULT 0.00');
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
