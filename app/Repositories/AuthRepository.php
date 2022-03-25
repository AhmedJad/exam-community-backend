<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use App\Models\EmailVerification;
use App\Models\PasswordReset;

class AuthRepository
{
    public function create($user)
    {
        return User::create($user);
    }
    public function createEmailVerification($emailVerification)
    {
        $emailVerification["created_at"] = Carbon::now();
        EmailVerification::create($emailVerification);
    }
    public function updateEmailVerification($emailVerification)
    {
        $_emailVerification = EmailVerification::where("email", $emailVerification["email"])->first();
        $_emailVerification->verification_code = $emailVerification["verification_code"];
        $_emailVerification["created_at"] = Carbon::now();
        $_emailVerification->save();
    }
    public function verifyUser($email, $verificationCode, $expirationTime)
    {
        $queryBuilder = EmailVerification::where("email", $email)
            ->where("verification_code", $verificationCode)
            ->where('created_at', '>', Carbon::now()->subMinutes($expirationTime));
        $emailVerification = $queryBuilder->first();
        if ($emailVerification) {
            $queryBuilder->delete();
            $user = User::where("email", $email)->first();
            $user->email_verified_at = !$user->email_verified_at ? Carbon::now() : $user->email_verified_at;
            $user->save();
        }
        return $emailVerification;
    }
    public function insertResetPassword($email, $token)
    {
        $passwordReset = PasswordReset::where("email", $email)->first();
        if ($passwordReset) {
            $passwordReset->token = $token;
            $passwordReset->created_at =  Carbon::now();
            $passwordReset->save();
        } else {
            PasswordReset::insert(['email' => $email, 'token' => $token, 'created_at' => Carbon::now()]);
        }
        return $token;
    }
    public function getPasswordReset($token, $expirationTime)
    {
        $passwordReset = PasswordReset::where('token', $token)
            ->where('created_at', '>', Carbon::now()->subMinutes($expirationTime))->first();
        return $passwordReset;
    }
    public function changePassword($password, $email)
    {
        User::where('email', $email)
            ->update(['password' => bcrypt($password)]);
        PasswordReset::where('email', $email)->delete();
    }
    public function editImage($authUserId,$image)
    {
        $user = User::find($authUserId);
        $oldImage = $user->image;
        $user->image = $image;
        $user->save();
        return $oldImage;
    }
}
