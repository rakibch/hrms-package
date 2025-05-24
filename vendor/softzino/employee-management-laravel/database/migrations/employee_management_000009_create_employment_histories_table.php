<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Softzino\EmployeeManagement\Base\Migration;
use Softzino\EmployeeManagement\Models\EmploymentHistory;

return new class extends Migration
{
    /**
     * The table name.
     */
    protected string $tableName;

    public function __construct()
    {
        $this->tableName = EmploymentHistory::getTableName();
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index();
            $table->unsignedBigInteger('designation_id')->index()->nullable();
            $table->string('employment_type', 10)->index()->comment('e.g., Full-time, Part-time, Contract');
            $table->text('comment')->nullable();
            $table->string('status', 10)->index()->comment('e.g., Active, Inactive, Terminated');
            $table->dateTime('start_date')->index();
            $table->dateTime('end_date')->nullable()->index();
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
