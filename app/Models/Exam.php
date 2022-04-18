<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        "questions" => "json",
        'start_date' => 'datetime:Y-m-d\TH:i',
        'end_date' => 'datetime:Y-m-d\TH:i'
    ];
    public $timestamps = false;
    public function examSolutions()
    {
        return $this->hasOne(ExamSolution::class);
    }
}
