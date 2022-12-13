<?php


namespace App\Repositories\Page;

use App\Models\Keyword;
use App\Models\Page;
use Illuminate\Http\Request;

class PageRepository implements PageInterface
{
    private $model;

    public function __construct(Page $page)
    {
        $this->model = $page;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function save(Request $request)
    {
        $page = $this->model->create([
            'user_id' => auth()->user()->id,
            'title' => $request->input('title'),
            'slug' => $this->slugify($request->input('title')),
            'excerpt' => $request->input('excerpt'),
            'description' => $request->input('description'),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
            'meta_title' => $request->input('meta_title'),
        ]);

        // Keywords
        $newKeywords = explode(',', $request->input('keywords'));
        $keywordIds = [];

        foreach ($newKeywords as $keyword) {
            $keyword = Keyword::firstOrCreate(['title' => $keyword]);
            array_push($keywordIds, $keyword->id);
        }

        $page->keywords()->sync($keywordIds);


        return $page;
    }

    private function slugify($name): string
    {
        return \Str::slug($name);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request, int $id)
    {
        $page = $this->model->findOrFail($id);

        $data = [
            'title' => $request->input('title'),
            'slug' => $this->slugify($request->input('title')),
            'excerpt' => $request->input('excerpt'),
            'description' => $request->input('description'),
            'published' => filter_var($request->input('published'), FILTER_VALIDATE_BOOLEAN),
            'meta_title' => $request->input('meta_title'),
        ];

        // Keywords
        $page->keywords()->detach();
        $newKeywords = explode(',', $request->input('keywords'));
        $keywordIds = [];

        foreach ($newKeywords as $keyword) {
            $keyword = Keyword::firstOrCreate(['title' => $keyword]);
            array_push($keywordIds, $keyword->id);
        }

        $page->keywords()->sync($keywordIds);

        return $page->update($data);
    }

    public function delete(int $id)
    {
        $page = $this->model->findOrFail($id);
        $page->keywords()->detach();
        $page->pageLinks()->delete();

        return $page->delete();
    }

    public function all(array $columns = [])
    {
        return count($columns) ? $this->model->select($columns)->orderBy('id')->get() : $this->model->orderBy('id')->get();
    }

    public function paginate($perPage = 10)
    {
        return $this->model->latest()
            ->when(request()->has('is_published'), function ($q) {
                $q->where('published', (bool)request('is_published'));
            })
            ->when(\request()->has('search'), function ($q) {
                $q->where('title', 'LIKE', '%' . \request('search') . '%');
            })
            ->paginate($perPage);
    }


}
