<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Studio;
use App\Helper\ApiResponse;
use App\Interfaces\StudioInterface;

class StudioController extends Controller
{
    protected $studioInterface;
    use ApiResponse;

    public function __construct(StudioInterface $studioInterface)
    {
        $this->studioInterface = $studioInterface;
    }


    public function CreateNewStudio(Request $request)
    {

        $studioNumber = $request->input('studio_number');
        $seatCapacity = $request->input('seat_capacity');

        $this->validate($request, [
            'studio_number' => 'required|integer|gt:0',
            'seat_capacity' => 'required|integer|gt:25',
        ]);

        $isExist = $this->studioInterface->FindStudioByNumber($studioNumber);
        if ($isExist != null) {
            return $this->errorResponse('Studio already exist', 400);
        }

        $studio = new Studio();

        $studio->studio_number = $studioNumber;
        $studio->seat_capacity = $seatCapacity;

        list($createdStudio, $error) = $this->studioInterface->CreateNewStudio($studio);
        if ($error != null) {
            return $this->errorResponse($error, 500);
        }

        return $this->successResponse($createdStudio, 'Create new movie studio successfully', 201);
    }
}
