<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Timeout;
use PDF;

class TimeoutController extends Controller
{
    public function processQRCode(Request $request)
    {
        // Get the QR code value from the request
        $qrCode = $request->input('qr_code');

        // Check if the QR code value matches a student ID
        $student = DB::table('students')->where('id', $qrCode)->first();

        if ($student) {
            // If student ID exists, insert a new record into the timeout table
            $timeOut = Carbon::now();
            DB::table('timeout')->insert([
                'student_id' => $student->id,
                'datetime' => $timeOut
            ]);

            // Return the student's details along with success response
            return response()->json([
                'success' => true,
                'student' => [
                    'id' => $student->id,
                    'f_name' => $student->f_name,
                    'l_name' => $student->l_name,
                    'course' => $student->course,
                    'timeout' => $timeOut->toDateTimeString()
                ]
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid student ID']);
        }
    }

    public function generatePDF()
    {
        $today = Carbon::today();
    
        $timeout = Timeout::whereDate('datetime', $today)->get();
        $pdf = PDF::loadView('timeoutpdf ', compact('timeout'));
        return $pdf->stream('timeout.pdf');
    }
}
