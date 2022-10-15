<?php

namespace App\Interfaces;

use App\Models\Studio;

interface StudioInterface
{
    public function CreateNewStudio(Studio $studio);

    public function FindStudioByNumber($studioNumber);
}