<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // Show the form
    public function showForm()
    {
        // Fetch employee options for the NIK field
        $employees = Employee::query()
            ->select('ID', 'user_login', 'Display_Name')
            ->get()
            ->mapWithKeys(function ($employee) {
                return [
                    $employee->user_login => $employee->user_login . ' - ' . $employee->Display_Name
                ];
            });

        return view('employee-form', compact('employees'));
    }

    // Handle the form submission
    public function submitForm(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'nik' => 'required|string',
            'name' => 'required|string',
            'department' => 'required|string',
            'shift' => 'required|string',
            'alasan_terlambat' => 'required|string',
            'nama_security' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam' => 'required|date_format:H:i',
        ]);

        // Process the form data
        // For example, you might want to store the data in the database

        // Redirect or return a response
        return redirect()->route('employee.form')->with('success', 'Form submitted successfully!');
    }
}
