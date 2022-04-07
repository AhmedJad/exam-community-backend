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
    ];
    public $timestamps = false;
    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d\TH:i') : null;
    }
    public function getEndDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d\TH:i') : null;
    }
}
