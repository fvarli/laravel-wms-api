<?php
namespace App\Repositories;

use App\Models\Pallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class PalletRepository implements PalletRepositoryInterface
{
    /**
     * Update an existing pallet.
     * @param int $id
     * @return Collection|Model|null
     */
    public function find(int $id)
    {
        return Pallet::query()->find($id);
    }

    /**
     * @param int $id
     * @return Collection|Model
     */
    public function findOrFail(int $id)
    {
        return Pallet::query()->findOrFail($id);
    }

    /**
     * Create a new pallet with the given data.
     * @param array $data
     * @return Model
     */
    public function create(array $data)
    {
        return Pallet::create($data);
    }

    /**
     * Update an existing pallet.
     * This method is used to save changes to a pallet model.
     * @param Model $pallet
     * @return Model
     */
    public function save(Model $pallet)
    {
        // Service katmanında status, ilişki güncellemeleri vb. yapıldıktan sonra kaydeder.
        $pallet->save();
        return $pallet;
    }
}
