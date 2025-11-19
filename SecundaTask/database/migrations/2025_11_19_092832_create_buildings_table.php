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
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->magellanPoint('location', 4326)->nullable();
            $table->timestamps();
        });

        DB::statement("CREATE INDEX buildings_location_gist ON buildings USING GIST (location);");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');

        DB::statement("DROP INDEX IF EXISTS buildings_location_gist;");
    }
};
