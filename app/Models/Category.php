<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    public function notes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'note_category', 'category_id', 'note_id');
    }

    public static function options($filter = [])
    {
        $categories = Category::all();

        // Filter categories based on the provided names
        $filteredCategories = $categories->whereIn('id', $filter);

        // Get the remaining categories
        $remainingCategories = $categories->diff($filteredCategories);

        // Concatenate filtered and remaining categories
        $orderedCategories = $filteredCategories->merge($remainingCategories);

        // Map the categories to the desired format
        $map = $orderedCategories->map(fn ($category) => ['name' => $category->name, 'id' => $category->id])->sortBy('name', SORT_NATURAL);

        return $map;
    }
}
