<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategoriesFullStructure extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            // اگر فیلدها وجود ندارند اضافه شوند
            if (!Schema::hasColumn('categories', 'code')) {
                $table->string('code', 24)->unique()->after('title');
            }
            if (!Schema::hasColumn('categories', 'type')) {
                $table->string('type', 24)->after('code');
            }
            if (!Schema::hasColumn('categories', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable()->after('type');
            }
            if (!Schema::hasColumn('categories', 'description')) {
                $table->string('description', 500)->nullable()->after('parent_id');
            }
            if (!Schema::hasColumn('categories', 'image')) {
                $table->string('image', 255)->nullable()->after('description');
            }
            if (!Schema::hasColumn('categories', 'active')) {
                $table->boolean('active')->default(true)->after('image');
            }
            if (!Schema::hasColumn('categories', 'person_type')) {
                $table->string('person_type', 100)->nullable()->after('active');
            }
            if (!Schema::hasColumn('categories', 'unit')) {
                $table->string('unit', 100)->nullable()->after('person_type');
            }
            if (!Schema::hasColumn('categories', 'tax')) {
                $table->decimal('tax', 6, 2)->nullable()->after('unit');
            }
            if (!Schema::hasColumn('categories', 'service_type')) {
                $table->string('service_type', 100)->nullable()->after('tax');
            }
            if (!Schema::hasColumn('categories', 'base_rate')) {
                $table->decimal('base_rate', 16, 2)->nullable()->after('service_type');
            }
        });
    }

    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            // حذف فیلدها در صورت نیاز
            if (Schema::hasColumn('categories', 'code')) $table->dropColumn('code');
            if (Schema::hasColumn('categories', 'type')) $table->dropColumn('type');
            if (Schema::hasColumn('categories', 'parent_id')) $table->dropColumn('parent_id');
            if (Schema::hasColumn('categories', 'description')) $table->dropColumn('description');
            if (Schema::hasColumn('categories', 'image')) $table->dropColumn('image');
            if (Schema::hasColumn('categories', 'active')) $table->dropColumn('active');
            if (Schema::hasColumn('categories', 'person_type')) $table->dropColumn('person_type');
            if (Schema::hasColumn('categories', 'unit')) $table->dropColumn('unit');
            if (Schema::hasColumn('categories', 'tax')) $table->dropColumn('tax');
            if (Schema::hasColumn('categories', 'service_type')) $table->dropColumn('service_type');
            if (Schema::hasColumn('categories', 'base_rate')) $table->dropColumn('base_rate');
        });
    }
}
