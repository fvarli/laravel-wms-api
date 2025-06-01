<?php
namespace App\Repositories;

interface BoxRepositoryInterface
{
    public function findOrFail(int $id);

    public function create(array $data);

    public function updateStatus(int $id, string $status);
}
