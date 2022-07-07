<?php

namespace App\Http\Controllers;

use App\Repositories\ExamSolutionRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ExamSolutionController extends Controller
{
    private $examSolutionRepository;
    function __construct(ExamSolutionRepository $examSolutionRepository)
    {
        $this->middleware("auth");
        $this->middleware("verified");
        $this->examSolutionRepository = $examSolutionRepository;
    }
    function getUsers()
    {
        $userId = JWTAuth::parseToken()->getPayload()->get("sub");
        $users = $this->examSolutionRepository->getUsersExcept($userId);
        foreach ($users as $user) {
            $user->image = $user->image ? "https://examcommunity.herokuapp.com/images/$user->image" : null;
        }
        return $users;
    }
    function getExams($userId)
    {
        return $this->markFirstSelectionSelected($this->examSolutionRepository->getExams(
            $userId,
            JWTAuth::parseToken()->getPayload()->get("sub")
        ));
    }
    function getChildren($parentId)
    {
        return $this->markFirstSelectionSelected($this->examSolutionRepository->getChildren(
            $parentId,
            JWTAuth::parseToken()->getPayload()->get("sub")
        ));
    }
    function solve(Request $request)
    {
        $exam = $this->examSolutionRepository->getExam(
            $request->exam_id,
            JWTAuth::parseToken()->getPayload()->get("sub")
        );
        if ($this->examUnavailable($exam)) return response()->json(["error" => "Exam unavailable"], 400);
        $solutionsStates = $this->getSolutionsStates($exam->questions, $request->solutions);
        $request->merge([
            "user_id" => JWTAuth::parseToken()->getPayload()->get("sub"),
            "result" => $solutionsStates["result"],
            "solutions" => $solutionsStates["solutions"]
        ]);
        if (!$exam->exercise) $this->examSolutionRepository->saveSolutions($request->input());
        return $solutionsStates;
    }
    //Commons

    //This function to hide the selected selections
    private function markFirstSelectionSelected($exams)
    {
        $newExams = [];
        foreach ($exams as $exam) {
            $newQuestions = [];
            if (!$exam->folder) {
                foreach ($exam->questions as $question) {
                    $newSelections = [];
                    foreach ($question["selections"] as $index => $selection) {
                        $selection["selected"] = $index == 0;
                        $newSelections[] = $selection;
                    }
                    $question["selections"] = $newSelections;
                    $newQuestions[] = $question;
                }
                $exam->questions = $newQuestions;
            }
            $newExams[] = $exam;
        }
        return $newExams;
    }
    private function getSolutionsStates($examQuestions, $requestSolutions)
    {
        $solutions = [];
        $correctAnswerCounter = 0;
        foreach ($requestSolutions as $solutionIndex => $solution) {
            $correctSelectionIndex = 0;
            $correctAnswer = $examQuestions[$solution["questionIndex"]]["selections"][$solution["selectedSelectionIndex"]]["selected"];
            if ($correctAnswer) {
                $correctAnswerCounter++;
                $correctSelectionIndex = $solution["selectedSelectionIndex"];
            } else {
                $correctSelectionIndex = $this->getCorrectSelection($examQuestions, $solution["questionIndex"]);
            }
            $solutions[] = [
                "questionIndex" => $solution["questionIndex"],
                "selectedSelectionIndex" => $solution["selectedSelectionIndex"],
                "correctSelectionIndex" => $correctSelectionIndex
            ];
        }
        return [
            "result" => $correctAnswerCounter . "/" . count($examQuestions),
            "solutions" => $solutions
        ];
    }
    private function getCorrectSelection($examQuestions, $questionIndex)
    {
        foreach ($examQuestions[$questionIndex]["selections"]
            as $selectionIndex => $selection) {
            if ($selection["selected"]) return $selectionIndex;
        }
    }
    private function examUnavailable($exam)
    {
        return $exam->examSolutions || (
            ($exam->start_date ? Carbon::now()->addHours(2)->lt($exam->start_date) : false)
            ||
            ($exam->end_date ? Carbon::now()->addHours(2)->gt($exam->end_date) : false)
        );
    }
}
