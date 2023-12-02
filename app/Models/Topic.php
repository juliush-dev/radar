<?php

namespace App\Models;

use App\Services\RadarQuery;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Topic extends Model
{
    use HasFactory, HasUuids;

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function potentialReplacement(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'potential_replacement');
    }

    public function potentialReplacementOf(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'potential_replacement_of');
    }

    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }

    public function previousTopic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'previous_topic_id');
    }

    public function fields(): HasMany
    {
        return $this->hasMany(TopicField::class);
    }

    public function years(): HasMany
    {
        return $this->hasMany(TopicYear::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(TopicSkill::class);
    }

    public function volatileNotes()
    {
        return $this->notes()->where(function ($query) {
            $query->where('is_public', false)->orWhere('potential_replacement', '!=', null);
        });
    }

    public function publicNotes()
    {
        return $this->notes()->where(
            RadarQuery::publicOrAuthor(Auth::id())
        );
    }

    public function applyUpdate()
    {
        $oldTopic = $this->potentialReplacementOf;
        if ($oldTopic->potentialReplacementOf) {
            $this->potential_replacement_of = $oldTopic->potentialReplacementOf->id;
            $oldTopic->potentialReplacementOf->potential_replacement = $this->id;
            $oldTopic->potentialReplacementOf->save();
        } else {
            $this->is_update = 0;
        }
        $this->copyNewNotesFromOldTopic();
        $this->notes()->where('is_update', true)->get()->each(function (Note $note) {
            $note->applyUpdate();
        });
        $oldTopic->delete();
        $this->is_public = true;
        $this->save();
    }

    public function copyNewNotesFromOldTopic()
    {
        // Retrieve notes in the old topic that do not have a potential replacement in the current topic
        $notesWithoutReplacement = $this->potentialReplacementOf->notes()
            ->whereNotIn(
                'id',
                $this->notes()->whereNotNull('potential_replacement_of')
                    ->pluck('potential_replacement_of')
                    ->all()
            )->get();
        $notesWithoutReplacement->each(function (Note $oldNote) {
            $noteCopy = $oldNote->copyToTopic($this);
            $noteCopy->categories()->attach($oldNote->categories()->pluck('category_id'));
            $noteCopy->categoryOf()->attach($oldNote->categoryOf()->pluck('note_id'));
        });
    }

    public static function published()
    {
        return Topic::where(
            RadarQuery::publicOrAuthor(Auth::id())
        );
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'topic_id');
    }

    public function inTheSameSubject()
    {
        return Topic::whereNot('id', $this->id)->where('subject_id', $this->subject_id)->where(
            RadarQuery::publicOrAuthor(Auth::id())
        );
    }
}
