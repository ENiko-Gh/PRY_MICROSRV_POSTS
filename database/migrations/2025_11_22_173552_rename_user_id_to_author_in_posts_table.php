<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('author')->after('content')->nullable();
        });

        // Opcional: copiar user_id a author si tuvieras datos, pero no es tu caso
        // DB::table('posts')->update(['author' => 'usuario_anonimo']);

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('content');
            $table->dropColumn('author');
        });
    }
};
