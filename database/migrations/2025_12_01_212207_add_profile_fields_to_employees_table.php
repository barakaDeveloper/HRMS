<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            // Personal Information
            $table->string('national_id')->nullable()->after('gender');
            $table->enum('marital_status', ['single', 'married', 'divorced', 'widowed'])->nullable()->after('national_id');
            
            // Employment Details
            $table->enum('employee_status', ['active', 'on_leave', 'terminated'])->default('active')->after('employment_type');
            $table->string('work_location')->nullable()->after('employee_status');
            
            // Work Performance (store as JSON for multiple KPIs)
            $table->json('key_performance_indicators')->nullable()->after('productivity');
            
            // Financial Information with Currency Support
            $table->string('bank_name')->nullable()->after('salary');
            $table->string('bank_account_number')->nullable()->after('bank_name');
            $table->string('bank_account_name')->nullable()->after('bank_account_number');
            $table->date('last_salary_increment_date')->nullable()->after('bank_account_name');
            
            // Bonus with currency
            $table->decimal('bonus', 12, 2)->nullable()->default(0)->after('last_salary_increment_date');
            $table->enum('bonus_currency', ['TZS', 'USD'])->default('TZS')->after('bonus');
            
            // Commission with currency
            $table->decimal('commission', 12, 2)->nullable()->default(0)->after('bonus_currency');
            $table->enum('commission_currency', ['TZS', 'USD'])->default('TZS')->after('commission');
            
            // Allowances with currency (added after commission)
            $table->decimal('allowances', 12, 2)->nullable()->default(0)->after('commission_currency');
            $table->enum('allowances_currency', ['TZS', 'USD'])->default('TZS')->after('allowances');
            
            // Salary currency (add after salary column)
            $table->enum('salary_currency', ['TZS', 'USD'])->default('TZS')->after('salary');
            
            // Documents (store as JSON array for multiple files)
            $table->json('documents')->nullable()->after('allowances_currency');
            
            // Add profile photo URL
            $table->string('profile_photo_url')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn([
                'national_id',
                'marital_status',
                'employee_status',
                'work_location',
                'key_performance_indicators',
                'bank_name',
                'bank_account_number',
                'bank_account_name',
                'last_salary_increment_date',
                'bonus',
                'bonus_currency',
                'commission',
                'commission_currency',
                'allowances',
                'allowances_currency',
                'salary_currency',
                'documents',
                'profile_photo_url'
            ]);
        });
    }
};