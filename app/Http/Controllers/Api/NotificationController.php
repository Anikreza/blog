<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;

class NotificationController extends Controller
{
    /**
     * Write code on Method
     *
     * @return bool
     */
    public function sendNotification(): bool
    {
        $article = Article::with(['categories' => function ($q) {
            $q->with(['articles' => function ($sq) {
                $sq->limit(4);
            }]);
        }])
            ->with('keywords')
            ->where('published', true)
            ->first();

        return \Artisan::call("send:notification", [
            'notificationData' => [
                "article_id" => $article->id,
                "title" => $article->title,
                "body" => $article->excerpt,
                "image" => $article->image
            ]
        ]);
    }
}
