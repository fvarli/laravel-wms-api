<?php

namespace App\Services;

use App\Repositories\PalletRepositoryInterface;
use App\Repositories\BoxRepositoryInterface;
use App\Models\Pallet;
use App\Models\InventoryMovement;

class PalletService
{
    /**
     * @var PalletRepositoryInterface
     */
    protected $repo;

    /**
     * @var BoxRepositoryInterface
     */
    protected $boxRepo;

    /**
     * @param PalletRepositoryInterface $repo
     * @param BoxRepositoryInterface    $boxRepo
     */
    public function __construct(
        PalletRepositoryInterface $repo,
        BoxRepositoryInterface $boxRepo
    ) {
        $this->repo    = $repo;
        $this->boxRepo = $boxRepo;
    }

    /**
     * Create a new pallet with the given barcode and user ID.
     * @param string $barcode
     * @param int    $userId
     * @return Pallet
     */
    public function createPallet(string $barcode, int $userId)
    {
        $data = [
            'barcode' => $barcode,
            'user_id' => $userId,
            'status'  => 'OPEN',
        ];

        return $this->repo->create($data);
    }

    /**
     * The process of completing a pallet: moves the boxes to the "IN_WMS" position,
     * creates an inventory_movements record. If the pallet is not found
     * or its status is not suitable, false is returned.
     * @param Pallet $pallet
     * @return Pallet|false
     */
    public function completePallet(Pallet $pallet)
    {
        // 1) Control of pallet status
        if ($pallet->status !== 'OPEN') {
            return false;
        }

        // 2) At least one box must be present on the pallet.
        if ($pallet->boxes()->count() === 0) {
            return false;
        }

        // 3) Apply business logic: update pallet status, update boxes, record movements.
        $pallet->status = 'COMPLETED';
        $this->repo->save($pallet);

        foreach ($pallet->boxes as $box) {
            // Make each box "IN_WMS"
            $this->boxRepo->updateStatus($box->id, 'IN_WMS');

            // InventoryMovement oluştur
            InventoryMovement::create([
                'box_id'       => $box->id,
                'movement_type'=> 'RECEIVE',
                'user_id'      => auth()->id(),
            ]);
        }

        return $pallet;
    }

    /**
     * Get the pallet by its ID. If the pallet does not exist, it throws a ModelNotFoundException.
     *
     * @param int $id
     */
    public function getPalletById(int $id)
    {
        return $this->repo->findOrFail($id);
    }
}
