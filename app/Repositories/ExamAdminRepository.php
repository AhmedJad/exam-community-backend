<?php

namespace App\Repositories;

use App\Models\Exam;

class ExamAdminRepository
{
    public function getExams($userId)
    {
        return Exam::where("user_id", $userId)->whereNull("exam_id")->get();
    }
    public function getChildren($parentId)
    {
        return Exam::where("exam_id", $parentId)->get();
    }
    public function create($exam)
    {
        $exam["questions"] = !$exam["folder"] ? [
            [
                "context" => "بلا عنوان",
                "selections" => [
                    ["context" => "بلا عنوان", "selected" => true],
                    ["context" => "بلا عنوان", "selected" => false],
                    ["context" => "بلا عنوان", "selected" => false],
                    ["context" => "بلا عنوان", "selected" => false],
                ]
            ]
        ] : null;
        return Exam::create(
            [
                "title" => $exam["title"], "folder" => $exam["folder"], "exam_id" => $exam["exam_id"],
                "user_id" => $exam["user_id"],
                "questions" => $exam["questions"], "selections_size" => !$exam["folder"] ? 4 : null
            ]
        );
    }
    public function rename($exam)
    {
        $exam = Exam::where("id", $exam["id"])->update(["title" => $exam["title"]]);
    }
    public function editExam($exam)
    {
        Exam::where("id", $exam["id"])->update($exam);
    }
    public function delete($id)
    {
        Exam::where("id", $id)->delete();
    }
}
