<?php
namespace App\Services;

use App\Repositories\BoxRepositoryInterface;
use App\Repositories\PalletRepositoryInterface;
use App\Models\InventoryMovement;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BoxService
{
    protected $boxRepo;
    protected $palletRepo;

    public function __construct(
        BoxRepositoryInterface $boxRepo,
        PalletRepositoryInterface $palletRepo
    ) {
        $this->boxRepo = $boxRepo;
        $this->palletRepo = $palletRepo;
    }

    /**
     * Scan the barcode and create a new box
     */
    public function createBox(string $barcode, int $palletId)
    {
        // Check if the pallet exists and is open
        try {
            $pallet = $this->palletRepo->findOrFail($palletId);
        } catch (ModelNotFoundException $e) {
            return null;
        }

        if ($pallet->status !== 'OPEN') {
            return null;
        }

        // Add the box
        $box = $this->boxRepo->create([
            'barcode'   => $barcode,
            'pallet_id' => $palletId,
            'status'    => 'SCANNED',
        ]);

        // Add the inventory movement for receiving the box
        InventoryMovement::create([
            'box_id'       => $box->id,
            'movement_type'=> 'RECEIVE',
            'user_id'      => auth()->id(),
        ]);

        return $box;
    }

    /**
     * Process of assigning a location to a box (PUTAWAY)
     */
    public function assignLocation(int $boxId, int $locationId)
    {
        try {
            $box = $this->boxRepo->findOrFail($boxId);
        } catch (ModelNotFoundException $e) {
            return null;
        }

        if ($box->status !== 'IN_WMS') {
            return null;
        }

        // Update the box status to 'TRANSFERRED'
        $box = $this->boxRepo->updateStatus($boxId, 'TRANSFERRED');

        InventoryMovement::create([
            'box_id'       => $boxId,
            'location_id'  => $locationId,
            'movement_type'=> 'PUTAWAY',
            'user_id'      => auth()->id(),
        ]);

        return $box;
    }
}
