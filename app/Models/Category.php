<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'note_category', 'category_id', 'note_id');
    }

    public static function options()
    {
        $map = Category::all()
            ->map(fn ($category) => ['name' => $category->name, 'id' => $category->id]);
        return $map;
    }
}
