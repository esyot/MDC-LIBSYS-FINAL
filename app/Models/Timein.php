<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timein extends Model
{
    use HasFactory;

    // Define the table name explicitly if it's not following Laravel's convention
    protected $table = 'timein';

    // Define the fillable attributes
    protected $fillable = [
        'student_id',
        'datetime',
    ];

    // Define relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
