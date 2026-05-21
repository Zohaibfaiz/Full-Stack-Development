<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Add a string column for role (admin, sub_admin, user)
        $table->string('role')->default('user')->after('email'); 

        // OPTIONAL: If you want to keep data, you can migrate old is_admin values here
        // using raw SQL, but for now, let's just add the column.
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('role');
    });
}
};
