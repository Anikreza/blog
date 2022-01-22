<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Page extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'excerpt',
        'meta_title',
        'published'
    ];

    /**
     * Article Keyword pivot collection
     * @return BelongsToMany
     */
    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class, 'page_keywords', 'page_id', 'keyword_id')->withPivot('id');
    }

    public function pageLinks(): HasMany
    {
        return $this->hasMany(PageLink::class, 'page_id', 'id');
    }
}
