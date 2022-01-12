<?php


namespace App\Repositories\User;


interface UserProfileModelInterface
{
    public function getTitleAttribute(): string;

    public function getNameAttribute(): string;

    public function allowedAttributesForProfile(): array;
}
