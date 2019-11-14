<?php


namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model $model
     */
    public $model;

    /**
     * @var int $page
     */
    public $page = 1;

    /**
     * @var int $perPage
     */
    public $perPage = 10;

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        return $this->model
            ->create($data)
            ->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function getOne(int $id): array
    {
        return $this->model
            ->find($id)
            ->toArray();
    }

    /**
     * @param bool $paginate
     * @param int|null $page
     * @param int|null $perPage
     * @return \Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function getAll(bool $paginate = false, int $page = null, int $perPage = null): array
    {
        if (!$paginate) {
            return $this->model
                ->all()
                ->toArray();
        }

        $page = !empty($page) ? $page : $this->page;
        $perPage = !empty($perPage) ? $perPage : $this->perPage;

        return $this->paginate($page, $perPage);
    }

    /**
     * @param mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model
            ->destroy($id);
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return array
     */
    private function paginate(int $page, int $perPage): array
    {
        return $this->model
            ->paginate($perPage, ['*'], 'page', $page)
            ->toArray();
    }
}