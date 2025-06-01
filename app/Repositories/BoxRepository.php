<?php
namespace App\Repositories;

use App\Models\Box;
use App\Repositories\BoxRepositoryInterface;

class BoxRepository implements BoxRepositoryInterface
{
    public function findOrFail(int $id)
    {
        return Box::query()->findOrFail($id);
    }

    public function create(array $data)
    {
        return Box::create($data);
    }

    public function updateStatus(int $id, string $status)
    {
        $box = $this->findOrFail($id);
        $box->status = $status;
        $box->save();
        return $box;
    }
}
