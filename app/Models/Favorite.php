<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = [
        'article_id',
        'device_id'
    ];

    /**
     * Article Relation
     * @return BelongsTo
     */
    public function articles(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

}
