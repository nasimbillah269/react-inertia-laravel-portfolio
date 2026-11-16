<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * `generals` table — generated from the live database schema.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('generals', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();
            $table->string('subtitle', 200)->nullable();
            $table->string('website', 100)->nullable();
            $table->string('logo', 100)->nullable();
            $table->string('pos_logo', 100)->nullable();
            $table->string('favicon', 100)->nullable();
            $table->string('banner', 100)->nullable();
            $table->string('mobile', 250)->nullable();
            $table->string('email', 250)->nullable();
            $table->text('address_one')->nullable();
            $table->text('address_two')->nullable();
            $table->string('postal_address', 191)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('division', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->boolean('commingsoon_mode')->default(0);
            $table->boolean('notification_status')->default(0);
            $table->integer('online_store_id')->nullable();
            $table->string('fb_pageId', 100)->nullable();
            $table->text('meta_keyword')->nullable();
            $table->string('meta_description', 200)->nullable();
            $table->string('meta_author', 100)->nullable();
            $table->string('meta_title', 200)->nullable();
            $table->longText('script_head')->nullable();
            $table->longText('script_body')->nullable();
            $table->longText('custom_css')->nullable();
            $table->longText('custom_js')->nullable();
            $table->text('copyright_text')->nullable();
            $table->string('mail_driver', 100)->nullable();
            $table->string('mail_host', 100)->nullable();
            $table->string('mail_port', 100)->nullable();
            $table->string('mail_username', 100)->nullable();
            $table->string('mail_password', 100)->nullable();
            $table->string('mail_encryption', 100)->nullable();
            $table->string('mail_from_name', 100)->nullable();
            $table->string('mail_from_address', 100)->nullable();
            $table->boolean('register_mail_user')->default(0);
            $table->boolean('register_mail_author')->default(0);
            $table->boolean('forget_password_mail_user')->default(0);
            $table->boolean('register_verify_mail_user')->default(0);
            $table->text('admin_mails')->nullable();
            $table->boolean('mail_status')->default(0);
            $table->string('sms_username', 50)->nullable();
            $table->string('sms_password', 50)->nullable();
            $table->string('sms_senderid', 50)->nullable();
            $table->string('sms_url_masking', 200)->nullable();
            $table->string('sms_url_nonmasking', 200)->nullable();
            $table->string('sms_type', 50)->nullable();
            $table->boolean('sms_status')->default(0);
            $table->boolean('register_sms_user')->default(0);
            $table->boolean('register_sms_author')->default(0);
            $table->boolean('forget_password_sms_user')->default(0);
            $table->boolean('register_verify_sms_user')->default(0);
            $table->text('admin_numbers')->nullable();
            $table->string('fb_app_id', 100)->nullable();
            $table->string('fb_app_secret', 100)->nullable();
            $table->string('fb_app_redirect_url', 200)->nullable();
            $table->string('tw_app_id', 100)->nullable();
            $table->string('tw_app_secret', 100)->nullable();
            $table->string('tw_app_redirect_url', 200)->nullable();
            $table->string('google_client_id', 100)->nullable();
            $table->string('google_client_secret', 100)->nullable();
            $table->string('google_client_redirect_url', 200)->nullable();
            $table->string('facebook_link', 200)->nullable();
            $table->string('twitter_link', 200)->nullable();
            $table->string('instagram_link', 200)->nullable();
            $table->string('linkedin_link', 200)->nullable();
            $table->string('pinterest_link', 200)->nullable();
            $table->string('youtube_link', 200)->nullable();
            $table->boolean('shipping_charge_type')->default(0);
            $table->float('defult_shipping_charge')->default(0.00);
            $table->float('tax')->default(0.00);
            $table->float('import_tax')->default(0.00);
            $table->boolean('tax_status')->default(0);
            $table->string('currency', 10)->nullable();
            $table->integer('currency_decimal')->default(0)->comment('0=0,1=0.0,2=0.00');
            $table->integer('currency_position')->default(0)->comment('0=left, 1=right');
            $table->boolean('seller_product_verify')->default(0);
            $table->boolean('coupon_apply')->default(0);
            $table->float('inside_dhaka_shipping_charge')->default(0.00);
            $table->float('outside_dhaka_shipping_charge')->default(0.00);
            $table->float('shipping_charge_free_limit')->default(0);
            $table->float('mix_amount')->default(0.00);
            $table->integer('slider')->nullable();
            $table->boolean('cus_reg_sms_customer')->default(0);
            $table->boolean('cus_reg_sms_admin')->default(0);
            $table->boolean('vendor_reg_sms_vendor')->default(0);
            $table->boolean('vendor_reg_sms_admin')->default(0);
            $table->boolean('order_place_sms_customer')->default(0);
            $table->boolean('order_place_sms_vendor')->default(0);
            $table->boolean('order_place_sms_admin')->default(0);
            $table->boolean('order_status_sms_customer')->default(0);
            $table->boolean('order_status_sms_vendor')->default(0);
            $table->boolean('order_status_sms_admin')->default(0);
            $table->boolean('order_payment_sms_customer')->default(0);
            $table->boolean('order_payment_sms_admin')->default(0);
            $table->boolean('Vendor_payment_sms_vendor')->default(0);
            $table->boolean('Vendor_payment_sms_admin')->default(0);
            $table->boolean('cus_recharge_sms_customer')->default(0);
            $table->boolean('cus_recharge_sms_admin')->default(0);
            $table->text('special_offce_text')->nullable();
            $table->boolean('special_offce_status')->default(0);
            $table->string('patho_store_id', 100)->nullable();
            $table->string('patho_client_id', 100)->nullable();
            $table->string('patho_client_secret', 100)->nullable();
            $table->string('patho_username', 100)->nullable();
            $table->string('patho_password', 100)->nullable();
            $table->text('patho_access_token')->nullable();
            $table->text('patho_refresh_token')->nullable();
            $table->text('master_admins')->nullable();
            $table->string('theme', 100)->nullable();
            $table->string('adminTheme', 50)->nullable();
            $table->float('balance')->default(0.00);
            $table->integer('last_id')->nullable();
            $table->timestamps();
        });

        // exact FLOAT columns (Blueprint::float() would create DOUBLE(8,2) on Laravel 10)
        DB::statement('ALTER TABLE `generals` MODIFY `defult_shipping_charge` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `generals` MODIFY `tax` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `generals` MODIFY `import_tax` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `generals` MODIFY `inside_dhaka_shipping_charge` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `generals` MODIFY `outside_dhaka_shipping_charge` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `generals` MODIFY `shipping_charge_free_limit` FLOAT NOT NULL DEFAULT 0');
        DB::statement('ALTER TABLE `generals` MODIFY `mix_amount` FLOAT(10,2) NOT NULL DEFAULT 0.00');
        DB::statement('ALTER TABLE `generals` MODIFY `balance` FLOAT(20,2) NOT NULL DEFAULT 0.00');
    }

    public function down(): void
    {
        Schema::dropIfExists('generals');
    }
};
