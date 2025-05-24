<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Softzino\EmployeeManagement\Base\Migration;
use Softzino\EmployeeManagement\Models\Certification;

return new class extends Migration
{
    /**
     * The table name.
     */
    protected string $tableName;

    public function __construct()
    {
        $this->tableName = Certification::getTableName();
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index();
            $table->string('course_name', 255);
            $table->string('issuing_organization', 255);
            $table->date('start_date');
            $table->date('completion_date')->nullable();
            $table->json('certificate_urls')->nullable();

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
        Schema::dropIfExists($this->tableName);
    }
};
