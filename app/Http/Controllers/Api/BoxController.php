<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignLocationRequest;
use App\Http\Requests\StoreBoxRequest;
use App\Models\Box;
use App\Services\BoxService;

class BoxController extends Controller
{

    protected $service;

    public function __construct(BoxService $service)
    {
        $this->service = $service;
    }

    // Add a new box (associate with pallet_id)
    public function store(StoreBoxRequest $request)
    {
        $box = $this->service->createBox(
            $request->barcode,
            $request->pallet_id
        );

        if (!$box) {
            return response()->json(['error'=>'The palette was not found or is not open.'], 422);
        }

        return response()->json(['box' => $box], 201);
    }

    // Assign a location to the box and record the WMS movement
    public function assignLocation(AssignLocationRequest $request, Box $box)
    {
        $box = $this->service->assignLocation($id, $request->location_id);

        if (!$box) {
            return response()->json(['error'=>'The box was not found or was not added to the WMS.'], 422);
        }

        return response()->json(['box' => $box]);
    }
}
