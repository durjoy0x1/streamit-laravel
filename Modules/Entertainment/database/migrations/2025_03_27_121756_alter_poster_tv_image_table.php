<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Constant\Models\Constant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('entertainments', function (Blueprint $table) {

            $table->text('poster_tv_url')->nullable();
        });

        Constant::create([
            'type' => 'upload_type',
            'name' => 'x265',
            'value' => 'x265',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
