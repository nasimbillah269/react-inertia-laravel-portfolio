<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = ['id'];

    protected $casts = ['status' => 'boolean', 'featured' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('status', true)->orderBy('sort_order')->orderByDesc('id');
    }

    public function tagList(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', (string) $this->tags))));
    }
}
