<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface PalletRepositoryInterface
{
    /**
     * Get the pallet with the specified ID, or return null if it does not exist.
     * @param int $id
     * @return Model|null
     */
    public function find(int $id);

    /**
     * Get the pallet with the specified ID,
     * or throw a ModelNotFoundException if it does not exist.
     * @param int $id
     * @return Model
     */
    public function findOrFail(int $id);

    /**
     * Create a new pallet.
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data);

    /**
     * Update an existing pallet.
     *
     * @param Model $pallet
     * @return Model
     */
    public function save(Model $pallet);
}
