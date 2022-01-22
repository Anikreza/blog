<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use App\Models\PageLink;
use App\Repositories\Page\PageRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class PageController extends ApiController
{
    public $pageRepository;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Returns All categories
     * @param Request $request
     * @return JsonResponse
     */

    public function index(Request $request): JsonResponse
    {
        return $this->successResponse($this->pageRepository->paginate($request->input('perPage')), true);
    }

    public function get(): JsonResponse
    {
        $pages = $this->pageRepository->all(['id', 'title']);
        $footerPageIds = PageLink::where(['key' => 'footer_pages'])->pluck('page_id');
        $appNavigationPageIds = PageLink::where(['key' => 'app_navigation_pages'])->pluck('page_id');

        return $this->successResponse(['pages' => $pages, 'footerPageIds' => $footerPageIds, 'appNavigationPageIds' => $appNavigationPageIds]);
    }

    /**
     * Creates Category & Returns created category
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|unique:pages,title|unique:articles,title'
        ]);

        \DB::beginTransaction();

        try {
            $page = $this->pageRepository->save($request);
            if ($page->published) {
                \Artisan::call('cache:clear');

                $data = [
                    "article_id" => $page->id,
                    "title" => $page->title,
                    "body" => $page->excerpt,
                    "image" => $page->thumb_image_url
                ];
                \Artisan::call("send:notification", [
                    'notificationData' => $data
                ]);
            }
            \DB::commit();

            return $this->successResponse($page);

        } catch (\Throwable $throwable) {
            \DB::rollBack();
            $this->errorLog($throwable, 'api');

            return $this->failResponse($throwable->getMessage());
        }

    }

    public function edit($slug): JsonResponse
    {
        try {
            $page = Page::where('slug', $slug)->with(['keywords'])->firstOrFail();

            return $this->successResponse($page);
        } catch (Exception $exception) {
            $this->errorLog($exception, 'api');

            return $this->failResponse($exception->getMessage());
        }
    }

    /**
     * Updates Category & Returns updated category
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'title' => 'required'
        ]);

        $category = $this->pageRepository->update($request, $id);
        \Artisan::call('cache:clear');

        return $this->successResponse($category);
    }

    /**
     * Deletes Category & Returns boolean
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->pageRepository->delete($id);
        \Artisan::call('cache:clear');

        return $this->successResponse();
    }

    public function savePageIds(Request $request): JsonResponse
    {
        $key = $request->input('widget_name', 'footer_pages');

        PageLink::where('key', $key)->delete();

        foreach ($request->input('ids') as $id) {
            $data = [
                'key' => $key,
                'page_id' => $id
            ];
            PageLink::insert($data);
        }
        \Artisan::call('cache:clear');

        return $this->successResponse();
    }
}
