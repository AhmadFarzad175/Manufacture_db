<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Owner;
use App\Models\Party;
use PhpOption\Option;
use App\Models\Branch;
use App\Models\Expense;
use App\Models\Holiday;
use App\Models\Employee;
use App\Models\Overtime;
use App\Models\deduction;
use App\Models\LeaveType;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\LoanOption;
use App\Models\Designation;
use App\Models\OfficeShift;
use App\Models\OwnerPickup;
use App\Models\EmployeeLoan;
use App\Models\LeaveRequest;
use App\Models\deductionOption;
use App\Models\ExpenseCategory;
use App\Models\PaymentReceived;
use App\Models\PaymentSent;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Branch::factory(10)->create();

        // Department::factory(10)->create();

        // Designation::factory(10)->create();

        // OfficeShift::factory(10)->create();

        ExpenseCategory::factory(10)->create();

        Party::factory(10)->create();

        Expense::factory(10)->create();

        // Holiday::factory(10)->create();

        // Employee::factory(10)->create();

        User::factory(10)->create();

        // Attendance::factory(10)->create();

        // LeaveType::factory(10)->create();

        // LeaveRequest::factory(10)->create();

        // Owner::factory(10)->create();

        PaymentSent::factory(10)->create();

        PaymentReceived::factory(10)->create();

        // OwnerPickup::factory(10)->create();

        // LoanOption::factory(10)->create();

        // EmployeeLoan::factory(10)->create();

        // Overtime::factory(10)->create();

        // deductionOption::factory(10)->create();

        // deduction::factory(10)->create();
    }
}
