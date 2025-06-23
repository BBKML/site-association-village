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
        Schema::table('articles', function (Blueprint $table) {
            if (!Schema::hasColumn('articles', 'excerpt')) {
                $table->string('excerpt', 500)->nullable()->after('content');
            }
            if (!Schema::hasColumn('articles', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('published_at');
            }
            if (!Schema::hasColumn('articles', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('category_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            }
            // Optionally drop author_id if exists
            if (Schema::hasColumn('articles', 'author_id')) {
                $table->dropForeign(['author_id']);
                $table->dropColumn('author_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            if (Schema::hasColumn('articles', 'excerpt')) {
                $table->dropColumn('excerpt');
            }
            if (Schema::hasColumn('articles', 'is_featured')) {
                $table->dropColumn('is_featured');
            }
            if (Schema::hasColumn('articles', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            // Optionally re-add author_id
            if (!Schema::hasColumn('articles', 'author_id')) {
                $table->unsignedBigInteger('author_id')->nullable();
            }
        });
    }
};
