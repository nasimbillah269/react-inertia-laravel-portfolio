<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * `attributes` table — generated from the live database schema.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->id();
            $table->string('name', 191)->nullable()->collation('utf8mb4_unicode_ci');
            $table->string('slug', 255)->nullable()->collation('utf8mb4_unicode_ci');
            $table->bigInteger('parent_id')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->bigInteger('src_id')->nullable();
            $table->text('short_description')->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('description')->nullable()->collation('utf8mb4_unicode_ci');
            $table->bigInteger('view')->default(0);
            $table->boolean('menu_type')->nullable()->comment('0=Custom Link, 1=Pages, 2=Post Categories, 3=Service Categories;');
            $table->string('location', 200)->nullable()->collation('utf8mb4_unicode_ci');
            $table->boolean('target')->default(0);
            $table->string('icon', 200)->nullable()->collation('utf8mb4_unicode_ci');
            $table->float('amounts')->default(0.00);
            $table->float('min_shopping')->nullable();
            $table->float('max_shopping')->nullable();
            $table->boolean('shipping_free')->default(0);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('seo_title', 200)->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('seo_description')->nullable()->collation('utf8mb4_unicode_ci');
            $table->text('seo_keyword')->nullable()->collation('utf8mb4_unicode_ci');
            $table->longText('data_counts')->nullable()->collation('utf8mb4_bin');
            $table->integer('type')->default(0)->comment('0=Category, 1=Slider, 2=Brand, 3=Client, 4=Galleries, 5=warehouse, 6=Blog Category, 7=Blog Tags 8=Menus, 9=Attributes 10=Product Tags, 11= Payment method, 12=expenses Type, 13=Coupons ,14=Promotions');
            $table->string('status', 10)->default('temp')->collation('utf8mb4_unicode_ci')->comment('temp, active, inactive');
            $table->boolean('fetured')->default(0);
            $table->bigInteger('addedby_id')->nullable();
            $table->bigInteger('editedby_id')->nullable();
            $table->timestamps();
        });

        // exact FLOAT columns (Blueprint::float() would create DOUBLE(8,2) on Laravel 10)
        DB::statement('ALTER TABLE `attributes` MODIFY `amounts` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `attributes` MODIFY `min_shopping` FLOAT NULL DEFAULT NULL');
        DB::statement('ALTER TABLE `attributes` MODIFY `max_shopping` FLOAT NULL DEFAULT NULL');
    }

    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
