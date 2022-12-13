<?php


namespace App\Repositories\AdSpace;


use App\Models\AdSpace;
use App\Services\FileUpload;

class AdSpaceRepository implements AdSpaceInterface
{
    private $model;

    public function __construct(AdSpace $adSpace)
    {
        $this->model = $adSpace;
    }

    public function create(array $data)
    {
        if (!$data['is_google'] && request()->hasFile('image')) {
            $data = $this->uploadImage($data);
        }

        return $this->model->create($data);
    }

    private function uploadImage($data)
    {
        $file = (new FileUpload(request()->file('image')))
            ->directory('/uploads/ads/')
            ->isImage()
            ->setFileName($data['name'])
            ->upload();

        $data['content'] = $file['main_file_name'];

        return $data;
    }

    public function getById(int $id)
    {
        return $this->model->find($id);
    }

    public function getByTitle(string $title)
    {
        return $this->model->where('name', $title)->first();
    }

    public function update(array $data, int $id)
    {
        if (!$data['is_google'] && request()->hasFile('image')) {
            $data = $this->uploadImage($data);
        }

        return $this->model->where('id', $id)->update($data);
    }

    public function delete(int $id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function all(array $columns = [], bool $fetchPublishedOnly = false)
    {
        return $this->model->when(count($columns), function ($q) use ($columns) {
            $q->select($columns);
        })->when($fetchPublishedOnly, function ($q) {
            $q->where('published', true);
        })->orderBy('id')->get();
    }
}
