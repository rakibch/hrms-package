<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Softzino\EmployeeManagement\Base\Migration;
use Softzino\EmployeeManagement\Models\Address;

return new class extends Migration
{
    /**
     * The table name.
     */
    protected string $tableName;

    public function __construct()
    {
        $this->tableName = Address::getTableName();
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->morphs('addressable');
            $table->string('type', 50)->index();
            $table->string('street', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->decimal('lat', 10, 8)->nullable(); // Latitude
            $table->decimal('lng', 11, 8)->nullable(); // Longitude
            $table->string('coordinates')->nullable(); // Coordinates as a string

            // Timestamps & Soft Deletes
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the table
        Schema::dropIfExists($this->tableName);
    }
};
