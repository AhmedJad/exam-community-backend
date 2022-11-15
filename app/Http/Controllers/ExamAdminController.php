<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamRequest;
use App\Repositories\ExamAdminRepository;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ExamAdminController extends Controller
{
    private $examAdminRepository;
    public function __construct(ExamAdminRepository $examAdminRepository)
    {
        $this->middleware("auth");
        $this->examAdminRepository = $examAdminRepository;
    }
    public function getExams()
    {
        $userId = JWTAuth::parseToken()->getPayload()->get("sub");
        return $this->examAdminRepository->getExams($userId);
    }
    public function getChildren($parentId)
    {
        return $this->examAdminRepository->getChildren($parentId);
    }
    //This method for init folder or exam
    public function create(Request $request)
    {
        $request->validate(['title' => 'required']);
        $userId = JWTAuth::parseToken()->getPayload()->get("sub");
        $request->merge(["user_id" => $userId]);
        return $this->examAdminRepository->create($request->input());
    }
    public function rename(Request $request)
    {
        $request->validate(['title' => 'required']);
        $this->examAdminRepository->rename($request->input());
    }
    public function editExam(ExamRequest $request){
        $this->examAdminRepository->editExam($request->input());
    }
    public function delete($id)
    {
        $this->examAdminRepository->delete($id);
    }
}
