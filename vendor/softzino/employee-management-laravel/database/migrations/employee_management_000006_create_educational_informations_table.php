<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Softzino\EmployeeManagement\Base\Migration;
use Softzino\EmployeeManagement\Models\EducationalInformation;

return new class extends Migration
{
    /**
     * The table name.
     */
    protected string $tableName;

    public function __construct()
    {
        $this->tableName = EducationalInformation::getTableName();
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index();
            $table->string('institution_name', 255);
            $table->string('degree', 255);
            $table->string('field_of_study', 255)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->decimal('grade', 5, 2)->nullable();
            $table->string('certificate_file_path')->nullable();
            $table->boolean('is_running')->default(false);

            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->timestamps();

            // Soft deletes for the table
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
