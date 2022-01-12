<?php


namespace App\Repositories\User;

use Illuminate\Http\Request;

interface UserInterface
{
    public function updateProfile($user, Request $request);

    public function updatePassword($userId);

    public function emailUpdate($userId);

    public function emailVerification($email);

    public function tokenVerification($email);
}
