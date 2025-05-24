<?php

namespace Softzino\EmployeeManagement\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Softzino\EmployeeManagement\Base\Migration;
use Softzino\EmployeeManagement\Models\Department;

return new class extends Migration
{
    /**
     * The table name.
     */
    protected string $tableName;

    public function __construct()
    {
        $this->tableName = Department::getTableName();
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();

            // Department Details
            $table->string('name', 60)->index();
            $table->unsignedBigInteger('head_id')->nullable()->index();
            $table->boolean('is_active')->default(false)->index();

            // Audit Columns
            $table->unsignedBigInteger('created_by')->index();
            $table->string('created_by_name')->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->string('updated_by_name')->nullable()->index();

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
