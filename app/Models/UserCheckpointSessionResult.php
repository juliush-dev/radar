<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCheckpointSessionResult extends Model
{
    use HasFactory, HasUuids;

    public function userCheckpointSession(): BelongsTo
    {
        return $this->belongsTo(UserCheckpointSession::class);
    }

    public function knowledge(): BelongsTo
    {
        return $this->belongsTo(CheckpointKnowledge::class);
    }

    public function potentialReplacement(): BelongsTo
    {
        return $this->belongsTo(UserCheckpointSessionResult::class, 'potential_replacement');
    }

    public function potentialReplacementOf(): BelongsTo
    {
        return $this->belongsTo(UserCheckpointSessionResult::class, 'potential_replacement_of');
    }

    public function copyToSession($session)
    {

        $resultCopy = $this->replicate();
        $resultCopy->session_id = $session->id;
        $resultCopy->knowledge_id = $this->knowledge->potential_replacement;
        $resultCopy->potential_replacement_of = $this->id;
        $resultCopy->is_update = true;
        $resultCopy->save();

        $this->potential_replacement = $resultCopy->id;
        $this->save();
        return $resultCopy;
    }

    public function applyUpdate()
    {
        $oldResult = $this->potentialReplacementOf;
        if ($oldResult->potentialReplacementOf) {
            $this->potential_replacement_of = $oldResult->potentialReplacementOf->id;
            $oldResult->potentialReplacementOf->potential_replacement = $this->id;
            $oldResult->potentialReplacementOf->save();
        } else {
            $this->is_update = 0;
        }
        $oldResult->delete();
        $this->save();
    }
}
