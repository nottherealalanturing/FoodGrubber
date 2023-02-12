<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('foody_admin')->create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category')->unique();
            $table->timestamps();
        });

        DB::connection('foody_admin')->table('categories')->insert([
            ['category' => 'Rice', 'created_at' => now(), 'updated_at' => now()],
            ['category' => 'Soup', 'created_at' => now(), 'updated_at' => now()],
            ['category' => 'Protein', 'created_at' => now(), 'updated_at' => now()],
            ['category' => 'Drinks', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('foody_admin')->dropIfExists('categories');
    }
};
