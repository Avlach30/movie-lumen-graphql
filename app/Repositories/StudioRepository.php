<?php

namespace App\Repositories;

use App\Interfaces\StudioInterface;
use App\Models\Studio;

class StudioRepository implements StudioInterface
{

    public function CreateNewStudio(Studio $studio)
    {
        try {
            $newStudio = $studio->save();

            return [$studio, null];
        } catch (\Exception $exception) {
            return [$studio, 'Create new movie studio failed'];
        }
    }

    public function FindStudioByNumber($studioNumber)
    {
        $studio = Studio::where('studio_number', $studioNumber)->first();
        if ($studio) {
            return $studio;
        }

        return null;
    }
}
