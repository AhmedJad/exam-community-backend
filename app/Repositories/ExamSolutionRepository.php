<?php

namespace App\Repositories;

use App\Models\Exam;
use App\Models\ExamSolution;
use App\Models\User;

class ExamSolutionRepository
{
    public function getExams($userId,$currentUserId)
    {
        return Exam::with(["examSolutions" => function ($query) use ($userId,$currentUserId) {
            $query->where("user_id", $currentUserId);
        }])->where("user_id", $userId)->whereNull("exam_id")->get();
    }
    public function getChildren($parentId, $userId)
    {
        return Exam::with(["examSolutions" => function ($query) use ($userId) {
            $query->where("user_id", $userId);
        }])->where("exam_id", $parentId)->get();
    }
    public function getUsersExcept($userId)
    {
        return User::where("id", "!=", $userId)->get();
    }
    public function getExam($id,$currentUserId)
    {
        return Exam::with(["examSolutions" => function ($query) use ($currentUserId) {
            $query->where("user_id", $currentUserId);
        }])->find($id);
    }
    public function saveSolutions($input)
    {
        ExamSolution::create($input);
    }
}
