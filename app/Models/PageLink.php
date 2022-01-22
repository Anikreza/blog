<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageLink extends BaseModel
{
    use HasFactory;

    protected $attributes = ['key', 'page_id'];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
