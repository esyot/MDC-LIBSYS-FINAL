<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class CSVController extends Controller
{
    public function generateCSV(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'f_name.*' => 'required|string',
            'l_name.*' => 'required|string',
            'm_name.*' => 'nullable|string',
            'course.*' => 'required|string',
            'contact_no.*' => 'required|string',
            'address.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Combine the form fields into CSV rows
        $csvData = [];
        foreach ($request->f_name as $key => $value) {  
            $csvData[] = [
                'id' => $key + 1, // Start ID from 1
                'f_name' => $this->escapeCSVValue($request->f_name[$key]),
                'l_name' => $this->escapeCSVValue($request->l_name[$key]),
                'm_name' => $this->escapeCSVValue($request->m_name[$key] ?? ''),
                'course' => $this->escapeCSVValue($request->course[$key]),
                'contact_no' => $this->escapeCSVValue($request->contact_no[$key]),
                'address' => $this->escapeCSVValue($request->address[$key]),
            ];
        }

        // Generate CSV content
        $csvContent = $this->generateCSVContent($csvData);

        // Store CSV content to a temporary file
        $tempFilePath = tempnam(sys_get_temp_dir(), 'students_');
        file_put_contents($tempFilePath, $csvContent);

        // Return CSV file as download
        return response()->download($tempFilePath, 'students.csv')->deleteFileAfterSend(true);
    }

    private function escapeCSVValue($value)
    {
        if (strpos($value, ',') !== false || strpos($value, '"') !== false || strpos($value, "\n") !== false) {
            $value = '"' . str_replace('"', '""', $value) . '"';
        }
        return $value;
    }

    private function generateCSVContent($csvData)
    {
        $csvContent = '';
        $header = array_keys($csvData[0]);
        $csvContent .= implode(',', $header) . "\n";

        foreach ($csvData as $row) {
            $csvContent .= implode(',', $row) . "\n";
        }

        return $csvContent;
    }

    public function import(Request $request)
    {
        //empty table
        DB::table('students')->delete();

        // Validate the uploaded CSV file
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        // Get the uploaded CSV file
        $file = $request->file('file');

        // Read the CSV file
        $csvData = array_map('str_getcsv', file($file->getPathname()));

        // Remove the header row
        $headers = array_shift($csvData);

        // Prepare data for bulk insert
        $studentsData = [];
        foreach ($csvData as $row) {
            // Map CSV columns to the database columns
            $student = [
         
                'f_name' => $row[1], // Actual f_name data
                'l_name' => $row[2],
                'm_name' => $row[3] ?? null,
                'course' => $row[4],
                'contact_no' => $row[5],
                'address' => $row[6],
            ];
            $studentsData[] = $student;
        }

        // Bulk insert into the database
        try {
            DB::beginTransaction();
            
            // Insert the data into the database
            Student::insert($studentsData);

            // Commit the transaction
            DB::commit();

            // Redirect back with success message
            return redirect('students');

        } catch (\Exception $e) {
            // Rollback the transaction in case of any error
            DB::rollBack();

            // Redirect back with error message
            return redirect()->back()->with('error', 'Failed to import CSV data. Please try again.');
        }
    }
}
