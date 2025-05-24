<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Softzino\EmployeeManagement\Base\Migration;
use Softzino\EmployeeManagement\Models\Employee;

return new class extends Migration
{
    /**
     * The table name.
     */
    protected string $tableName;

    public function __construct()
    {
        $this->tableName = Employee::getTableName();
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();

            // Employee Identity
            $table->enum('identity_type', ['automatic', 'manual'])->comment('Automatic or Manual')->index();
            $table->string('employee_no', 32)->unique()->index();
            $table->date('join_date')->index();

            // Personal Information
            $table->string('first_name', 60)->nullable()->index();
            $table->string('last_name', 60)->nullable()->index();
            $table->string('profile_image')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender', 6)->nullable()->index();
            $table->string('marital_status', 12)->nullable()->index();
            $table->string('religion', 20)->nullable()->index();
            $table->string('blood_group', 6)->nullable()->index();
            $table->string('personal_contact_no', 20)->nullable();
            $table->string('personal_email')->nullable();

            // Address Information
            $table->boolean('permanent_address_same_as_present_address')->default(true);
            $table->boolean('work_address_same_as_present_address')->default(false);

            // Job Information
            $table->string('job_type', 20)->nullable()->index()->comment('On-site, Remote, Hybrid, etc.');
            $table->unsignedBigInteger('department_id')->nullable()->index();
            $table->unsignedBigInteger('designation_id')->nullable()->index();
            $table->string('employment_type', 20)->nullable()->index()->comment('Intern, Probation, Permanent, etc.');

            $table->string('official_contact_no', 20)->nullable();
            $table->string('official_email')->nullable();

            // User & Profile Status
            $table->unsignedBigInteger('user_id')->index();
            $table->enum('profile_completion_status', ['draft', 'complete'])->default('draft')->index();
            $table->enum('employment_status', ['active', 'terminated', 'resigned', 'inactive'])
                ->default('inactive')
                ->index()->comment('Tracks the current employment status of the employee');

            // Meta
            $table->unsignedBigInteger('created_by')->index();
            $table->string('created_by_name');
            $table->unsignedBigInteger('updated_by')->nullable()->index();
            $table->string('updated_by_name')->nullable();
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
