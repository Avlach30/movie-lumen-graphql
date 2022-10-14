<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Studio;
use App\Helper\ApiResponse;


class StudioController extends Controller
{
    use ApiResponse;

    public function CreateNewStudio(Request $request)
    {
        $this->validate($request, [
            'studio_number' => 'required|integer|gt:0',
            'seat_capacity' => 'required|integer|gt:25',
        ]);

        $isExist = Studio::where('studio_number',$request->input('studio_number'))->first();
        if ($isExist) {
            return $this->errorResponse('Movie studio already exist', 400);
        }

        $studio = new Studio();

        $studio->studio_number = $request->input('studio_number');
        $studio->seat_capacity = $request->input('seat_capacity');

        $studio->save();

        return $this->successResponse($studio, 'Create new movie studio successfully', 201);
    }
}
