<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pallet;
use App\Services\PalletService;
use App\Http\Requests\StorePalletRequest;
use App\Http\Requests\CompletePalletRequest;

class PalletController extends Controller
{
    protected $service;

    public function __construct(PalletService $service)
    {
        $this->service = $service;
    }

    // Create a new pallet (start receiving goods)
    public function store(StorePalletRequest $request)
    {
        $userId = auth()->id();

        $pallet = $this->service->createPallet(
            $request->barcode,
            $userId
        );

        return response()->json(['pallet' => $pallet], 201);
    }

    // Get pallet details (including boxes)
    public function show(Pallet $pallet)
    {
        // İlişkili kutuları da yükleyelim
        $pallet->load('boxes');

        return response()->json(['pallet' => $pallet]);
    }

    // Complete the pallet: add boxes to WMS and create inventory movements
    public function complete(CompletePalletRequest $request, Pallet $pallet)
    {

        $updated = $this->service->completePallet($pallet);

        if (!$updated) {
            return response()->json([
                'error' => 'The palette was not found or is already complete.',
            ], 422);
        }

        return response()->json(['pallet' => $updated]);
    }
}
