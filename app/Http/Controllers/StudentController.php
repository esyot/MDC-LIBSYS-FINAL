<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use PDF;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'm_name' => 'nullable|string',
            'course' => 'required|string',
            'contact_no' => 'required|string',
            'address' => 'required|string',
        ]);

        // Create a new student record
        Student::create([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'm_name' => $request->m_name,
            'course' => $request->course,
            'contact_no' => $request->contact_no,
            'address' => $request->address,
        ]);

        // Redirect back to the form with a success message
        return redirect()->route('students')->with('success', 'Student created successfully.');
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'm_name' => 'nullable|string|max:255',
            'course' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_no' => 'required|string|max:20',
        ]);

        // Find the student by ID
        $student = Student::findOrFail($id);

        // Update the student record with validated data
        $student->update($validatedData);

        // Optionally, you can return a response indicating success
        return response()->json(['message' => 'Student updated successfully'], 200);
    }

    public function show($id)
    {
        $student = Student::find($id);
        
        if (!$student) {
            return response()->json(['error' => 'Student not found'], 404);
        }

        return response()->json($student);
    }

    public function generatePDF()
    {
        $students = Student::all();
        $pdf = PDF::loadView('pdf', compact('students'));
        return $pdf->stream('registered_students.pdf');
    }
    

    public function delete($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        
        return redirect()->route('students')->with('success', 'Student deleted successfully.');
    }

    public function generateCsv()
    {
        $students = Student::all();
    
        // Prepare the CSV header
        $csvData = [];
        $csvData[] = ['ID', 'First Name', 'Last Name', 'Middle Name', 'Course', 'Contact No', 'Address'];
    
        // Populate the CSV data with student records
        foreach ($students as $student) {
            $csvData[] = [
                $this->escapeCSVValue($student->id),
                $this->escapeCSVValue($student->f_name),
                $this->escapeCSVValue($student->l_name),
                $this->escapeCSVValue($student->m_name),
                $this->escapeCSVValue($student->course),
                $this->escapeCSVValue($student->contact_no),
                $this->escapeCSVValue($student->address),
                
            ];
        }
    
        // Define the CSV filename
        $filename = "students_" . date('Y-m-d_H-i-s') . ".csv";
    
        // Set the CSV headers for the response
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
    
        // Create the CSV file stream
        $callback = function() use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    
    // Function to remove double quotes from CSV values
    private function escapeCSVValue($value)
    {
        return str_replace('"', '', $value);
    }
    

}
