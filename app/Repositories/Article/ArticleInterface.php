<?php
namespace App\Repositories\Article;
use Illuminate\Http\Request;
interface ArticleInterface
{
    public function save(Request $request);

    public function update(Request $request, int $id);

    public function delete(int $id);

    public function paginateWithFilter(int $limit);

    public function paginateByCategoryWithFilter(int $perPage, int $categoryId);

}
