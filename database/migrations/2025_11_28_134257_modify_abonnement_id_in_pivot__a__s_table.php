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
        Schema::table('pivot__a__s', function (Blueprint $table) {
            // $table->dropColumn('abonnement_id');
            // $table->dropColumn('service_id');

            $table->unsignedBigInteger('abonnement_id');

            $table->foreign('abonnement_id')
                ->references('id')
                ->on('abonnements')
                ->onDelete('cascade');
            /*   $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services'); */
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pivot__a__s', function (Blueprint $table) {
            //
        });
    }
};
