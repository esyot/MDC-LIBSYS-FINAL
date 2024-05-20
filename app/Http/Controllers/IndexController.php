<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Timein;
use App\Models\Timeout;
use Illuminate\Support\Carbon;

class IndexController extends Controller
{
    public function dashboard(){
        return view('main');
    }

    public function timein(){
        return view('timein');
    }

    public function timeout(){
        return view('timeout');
    }

    public function register(){
        return view('register');
    }

    public function csv(){
        return view('csv');
    }

    public function importcsv(){
        return view('importcsv');
    }

    public function opencsv(){
        return view('opencsv');
    }

    public function monitor()
    {
        $today = Carbon::today();
    
        $timein = Timein::whereDate('datetime', $today)->get();
        $timeout = Timeout::whereDate('datetime', $today)->get();
    
        return view('monitor')->with(compact('timein', 'timeout'));
    }
    
    public function students(){
        $students = Student::all();

        return view('students',compact('students'));

    }
}
