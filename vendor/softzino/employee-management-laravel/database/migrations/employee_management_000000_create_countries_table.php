<?php

namespace Softzino\EmployeeManagement\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Softzino\EmployeeManagement\Base\Migration;
use Softzino\EmployeeManagement\Database\Seeders\CountrySeeder;
use Softzino\EmployeeManagement\Models\Country;

return new class extends Migration
{
    /**
     * The table name.
     */
    protected string $tableName;

    public function __construct()
    {
        $this->tableName = Country::getTableName();
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();

            // Country Details
            $table->string('name', 100);
            $table->char('iso2_code', 2)->unique();
            $table->char('iso3_code', 3)->unique();
            $table->string('phone_code', 10);
            $table->string('phone_regex', 255);
            $table->char('currency_code', 3);
            $table->string('currency_symbol', 10)->nullable();
            $table->string('timezone', 50);
            $table->string('currency_name', 60)->nullable();

            // Timestamps & Soft Deletes
            $table->timestamps();
            $table->softDeletes();
        });

        // After creating the table, run the country seeder
        Artisan::call('db:seed', [
            '--class' => CountrySeeder::class,
            '--force' => true, // To force running in production
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
