<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSolution extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = [
        "solutions" => "json",
    ];
}
