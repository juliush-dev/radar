<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Note extends Model
{
    use HasFactory, HasUuids;

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
    public function copyToTopic($topic)
    {

        $noteCopy = $this->replicate();
        $noteCopy->topic_id = $topic->id;
        $noteCopy->potential_replacement_of = $this->id;
        $noteCopy->is_update = true;
        $noteCopy->save();

        $this->potential_replacement = $noteCopy->id;
        $this->save();
        return $noteCopy;
    }

    public function applyUpdate()
    {
        $oldNote = $this->potentialReplacementOf;
        if ($oldNote->potentialReplacementOf) {
            $this->potential_replacement_of = $oldNote->potentialReplacementOf->id;
            $oldNote->potentialReplacementOf->potential_replacement = $this->id;
            $oldNote->potentialReplacementOf->save();
        } else {
            $this->is_update = 0;
        }
        $oldNote->delete();
        $this->is_public = true;
        $this->save();
    }
    // the notes this note is referecd by
    public function categoryOf(): BelongsToMany
    {
        return $this->BelongsToMany(Note::class, 'note_category', 'category_id', 'note_id'); // the note using it reference it as their category
    }

    // the notes this note uses as categories
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'note_category', 'note_id', 'category_id'); // its categories reference it by its id
    }

    public function categoriesMap()
    {
        $map =  $this->categories->map(fn ($note) => ['title' => $note->extractTitle(), 'id' => $note->id, 'topic' => $note->topic->title, 'topic_id' => $note->topic->id]);
        return $map;
    }

    public function categoriesOptions()
    {
        $map = Note::whereNot('id', $this->id)
            ->where(\App\Services\RadarQuery::publicOrAuthor())
            ->get()
            ->map(fn ($note) => ['title' => $note->extractTitle(), 'id' => $note->id, 'topic' => $note->topic->title, 'topic_id' => $note->topic->id]);
        return $map;
    }

    public function extractTitle()
    {
        $temp = "Headless note";
        if (preg_match('/<h\d[^>]*>(.*?)<\/h\d>/i', $this->content, $matches)) {
            $firstHeadingText = $matches[1];
            $title =  $firstHeadingText;
        }
        if (strlen(trim($title)) == 0) {
            $title = $temp;
        }
        return $title;
    }

    public function potentialReplacement(): BelongsTo
    {
        return $this->belongsTo(Note::class, 'potential_replacement');
    }

    public function potentialReplacementOf(): BelongsTo
    {
        return $this->belongsTo(Note::class, 'potential_replacement_of');
    }
}
