<?php


namespace App\Repositories\AdSpace;


interface AdSpaceInterface
{
    public function create(array $data);

    public function getById(int $id);

    public function getByTitle(string $title);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function all(array $columns = [], bool $fetchPublishedOnly = false);
}
