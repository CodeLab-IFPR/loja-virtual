<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            // SQLite cannot alter CHECK constraints; recreate the table
            DB::statement('PRAGMA foreign_keys = OFF');

            DB::statement("CREATE TABLE \"orders_new\" (
                \"id\" integer primary key autoincrement not null,
                \"order_number\" varchar not null,
                \"user_id\" integer not null,
                \"status\" varchar check (\"status\" in ('pending','processing','accepted','rejected','shipped','delivered','cancelled')) not null default 'pending',
                \"payment_method\" varchar null,
                \"subtotal\" numeric(10,2) not null,
                \"tax\" numeric(10,2) not null default '0',
                \"shipping\" numeric(10,2) not null default '0',
                \"discount\" numeric(10,2) not null default '0',
                \"total\" numeric(10,2) not null,
                \"customer_notes\" text null,
                \"admin_notes\" text null,
                \"billing_address\" text not null,
                \"shipping_address\" text null,
                \"shipped_at\" datetime null,
                \"delivered_at\" datetime null,
                \"accepted_at\" datetime null,
                \"rejected_at\" datetime null,
                \"created_at\" datetime null,
                \"updated_at\" datetime null,
                foreign key(\"user_id\") references \"users\"(\"id\") on delete cascade
            )");

            DB::statement("INSERT INTO \"orders_new\" (
                id, order_number, user_id, status, payment_method,
                subtotal, tax, shipping, discount, total,
                customer_notes, admin_notes, billing_address, shipping_address,
                shipped_at, delivered_at, accepted_at, rejected_at,
                created_at, updated_at
            ) SELECT
                id, order_number, user_id, status, payment_method,
                subtotal, tax, shipping, 0, total,
                customer_notes, admin_notes, billing_address, shipping_address,
                shipped_at, delivered_at, accepted_at, rejected_at,
                created_at, updated_at
            FROM \"orders\"");

            DB::statement('DROP TABLE "orders"');
            DB::statement('ALTER TABLE "orders_new" RENAME TO "orders"');

            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            // MySQL/MariaDB: just add the discount column
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('discount', 10, 2)->default(0)->after('shipping');
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('discount');
        });
    }
};
