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

    public function learningMaterials(): HasMany
    {
        return $this->hasMany(LearningMaterial::class);
    }

    public function checkpoints(): HasMany
    {
        return $this->hasMany(Checkpoint::class);
    }
    public function volatileCheckpoints()
    {
        return $this->checkpoints()->where(function ($query) {
            $query->where('is_public', false)->orWhere('potential_replacement', '!=', null);
        });
    }

    public function publicCheckpoints()
    {
        return $this->checkpoints()->where(
            RadarQuery::publicOrAuthor(Auth::id())
        );
    }

    public function volatileLearningMaterials()
    {
        return $this->learningMaterials()->where('is_public', false);
    }

    public function publicLearningMaterials()
    {
        return $this->learningMaterials()->where(
            function ($query) {
                $query->where('is_public', true)
                    ->orWhere('user_id', Auth::id());
            }
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
        $this->copyNewCheckpointsFromOldTopic();
        $this->copyNewKnowledgeCubesFromReplacements();
        $this->copyNewLearningMaterialsFromOldTopic();
        $this->copyResultsForReplacedSessions();
        $this->checkpoints()->where('is_update', true)->get()->each(function (Checkpoint $checkpoint) {
            $checkpoint->applyUpdate();
        });
        $oldTopic->delete();
        $this->is_public = true;
        $this->save();
    }

    public function copyNewKnowledgeCubesFromReplacements()
    {
        // Retrieve all checkpoints in the current topic
        $this->checkpoints->each(function ($checkpoint) {
            // Check if the checkpoint has a potential replacement in the current topic
            $replacementCheckpoint = $this->checkpoints()
                ->where('potential_replacement_of', $checkpoint->id)
                ->first();
            if ($replacementCheckpoint) {
                // Check for new knowledge cubes in the replacement checkpoint
                $replacementCheckpoint->knowledgeCubes()->where('potential_replacement_of', null)->get()
                    ->each(function ($knowledgeCube) use ($checkpoint) {
                        // Replicate and save the new knowledge cube in the current checkpoint
                        $knowledgeCubeCopy = $knowledgeCube->cobyToCheckpoint($checkpoint);
                        // Copy knowledge related to the new knowledge cube
                        $knowledgeCube->knowledge->each(function ($knowledge) use ($knowledgeCubeCopy) {
                            $knowledge->copyToCube($knowledgeCubeCopy);
                        });
                    });
            }
        });
    }
    // Add this method to your Topic model
    // Assuming you have a checkpoints relationship defined in the Topic model
    public function copyNewCheckpointsFromOldTopic()
    {
        // Retrieve checkpoints in the old topic that do not have a potential replacement in the current topic
        $checkpointsWithoutReplacement = $this->potentialReplacementOf->checkpoints()
            ->whereNotIn(
                'id',
                $this->checkpoints()->whereNotNull('potential_replacement_of')
                    ->pluck('potential_replacement_of')
                    ->all()
            )->get();
        $checkpointsWithoutReplacement->each(function ($oldCheckpoint) {
            $checkpointCopy = $oldCheckpoint->copyToTopic($this);
            $checkpointCopy->copyNewCubesFromOldCheckpoint();
            $checkpointCopy->copyNewSessionsFromOldCheckpoint();
        });
    }

    public function copyNewLearningMaterialsFromOldTopic()
    {
        // Retrieve learning materials in the old topic that are not in the current topic
        $learningMaterialsWithoutReplacement = $this->potentialReplacementOf->learningMaterials()
            ->whereNotIn(
                'alternative',
                $this->learningMaterials()->pluck('alternative')->all()
            )->get();

        $learningMaterialsWithoutReplacement->each(function ($learningMaterial) {
            // Replicate and save the new learning material in the current topic
            $learningMaterial->copyToTopic($this);
        });
    }

    // Add this method to your Topic model
    // Assuming you have relationships named checkpoints, userSessions, userResults, and knowledge in your models
    public function copyResultsForReplacedSessions()
    {
        // Retrieve checkpoints in the old topic with replacements in the current topic
        $checkpointsWithReplacement = $this->potentialReplacementOf->checkpoints()
            ->whereNotNull('potential_replacement_of')
            ->get();

        $checkpointsWithReplacement->each(function ($oldCheckpoint) {
            // Find the corresponding replacement checkpoint in the current topic
            $replacementCheckpoint = $this->checkpoints()
                ->where('potential_replacement_of', $oldCheckpoint->id)
                ->first();

            if ($replacementCheckpoint) {
                // Retrieve sessions in the old checkpoint with replacements
                $sessionsWithReplacement = $oldCheckpoint->userSessions()
                    ->whereNotNull('potential_replacement_of')
                    ->get();

                $sessionsWithReplacement->each(function ($oldSession) use ($replacementCheckpoint) {
                    // Find the corresponding replacement session in the current checkpoint
                    $replacementSession = $replacementCheckpoint->userSessions()
                        ->where('potential_replacement_of', $oldSession->id)
                        ->first();

                    if ($replacementSession) {
                        // Retrieve results in the old session without replacements
                        $resultsWithoutReplacement = $oldSession->userResults()
                            ->whereNull('potential_replacement')
                            ->get();

                        // Copy user results without replacements to the replacement session
                        $resultsWithoutReplacement->each(function ($result) use ($replacementSession) {
                            $result->copyToSession($replacementSession);
                        });
                    }
                });
            }
        });
    }
    public function myTopics(): HasMany
    {
        return $this->hasMany(MyTopic::class);
    }

    public static function published()
    {
        return Topic::where(
            RadarQuery::publicOrAuthor(Auth::id())
        );
    }
}
