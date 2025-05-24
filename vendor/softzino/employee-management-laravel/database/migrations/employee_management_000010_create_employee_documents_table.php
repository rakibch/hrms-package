<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Softzino\EmployeeManagement\Base\Migration;
use Softzino\EmployeeManagement\Models\EmployeeDocument;

return new class extends Migration
{
    /**
     * The table name.
     */
    protected string $tableName;

    public function __construct()
    {
        $this->tableName = EmployeeDocument::getTableName();
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index();
            $table->string('document_type', 50);
            $table->string('document_path', 255);
            $table->date('expiry_date')->nullable();

            $table->unsignedBigInteger('created_by')->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();
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
