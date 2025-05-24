<?php

namespace Softzino\EmployeeManagement\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Softzino\EmployeeManagement\Base\Migration;
use Softzino\EmployeeManagement\Models\Designation;

return new class extends Migration
{
    /**
     * Table name.
     */
    protected string $tableName;

    public function __construct()
    {
        $this->tableName = Designation::getTableName();
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();

            // Designation Information
            $table->string('name', 60)->index();
            $table->boolean('is_active')->default(false)->index();
            $table->foreignId('reporting_to_designation_id')->nullable()->index()->constrained($this->tableName)->nullOnDelete();

            // Audit Columns
            $table->unsignedBigInteger('created_by')->index();
            $table->string('created_by_name')->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->string('updated_by_name')->nullable()->index();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
