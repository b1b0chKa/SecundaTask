
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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE activities ALTER COLUMN path TYPE ltree USING path::ltree");

        DB::statement("
            ALTER TABLE activities
            ADD CONSTRAINT activities_path_level_check
            CHECK (nlevel(path) <= 3)
        ");

        DB::statement("
            ALTER TABLE activities
            ADD CONSTRAINT activities_parent_id_foreign
            FOREIGN KEY (parent_id) REFERENCES activities(id) ON DELETE SET NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE activities
            DROP CONSTRAINT IF EXISTS activities_path_level_check;
        ");

        Schema::dropIfExists('activities');
    }
};
