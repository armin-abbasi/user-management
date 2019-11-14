<?php


namespace App\Repositories\Base;


interface RepositoryInterface
{
    public function create(array $data): array;

    public function getOne(int $id): array;

    public function getAll(bool $paginate, int $page, int $perPage): array;

    public function delete($id);
}