<?php

namespace App\Providers;

use App\Models\Checkpoint;
use App\Models\LearningMaterial;
use App\Models\Skill;
use App\Models\Topic;
use App\Models\User;
use App\Models\UserCheckpointSession;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / author->idization services.
     */
    public function boot(): void
    {

        Gate::define('login', function (User $user) {
            return !$user->blocked;
        });

        Gate::define('use-dashboard', function (User $user) {
            return $user->is_admin && !$user->blocked;
        });

        Gate::define('update-profile', function (User $user, User $profile) {
            return ($user->id === $profile->id) && !$user->blocked || $user->is_admin && !$user->blocked;
        });
        Gate::define('delete-profile', function (User $user, User $profile) {
            return ($user->id === $profile->id) && !$user->blocked || $user->is_admin && !$user->blocked;
        });

        Gate::define('create-topic', function (?User $user) {
            return !$user?->blocked || $user == null;
        });
        Gate::define('see-topic', function (?User $user, Topic $topic) {
            return (!$user?->blocked || $user == null) && (($topic->is_public && !$topic->is_update) || (!$topic->is_public && (!empty($user) && $user->id == $topic->author->id)) || (!empty($user) && $user->is_admin));
        });
        Gate::define('update-topic', function (User $user, ?Topic $topic) {
            return $topic != null ? !isset($topic->potential_replacement) && (($user->id === $topic->author?->id) && !$user->blocked || $user->is_admin && !$user->blocked) : $user->is_admin && !$user->blocked;
        });
        Gate::define('see-topic-update-path', function (User $user, ?Topic $topic) {
            return $topic != null ? (($user->id === $topic->author?->id) && !$user->blocked || $user->is_admin && !$user->blocked) : $user->is_admin && !$user->blocked;
        });
        Gate::define('delete-topic', function (User $user, ?Topic $topic) {
            return $topic != null ? ($user->id === $topic->author?->id) && !$user->blocked || $user->is_admin && !$user->blocked : $user->is_admin && !$user->blocked;
        });

        Gate::define('assess-skill', function (User $user) {
            return !$user->blocked;
        });

        Gate::define('delete-learning-material', function (User $user, ?LearningMaterial $lm) {
            return $lm != null ? $user->id === $lm->author?->id && !$user->blocked || $user->is_admin && !$user->blocked : $user->is_admin && !$user->blocked;
        });

        Gate::define('create-skill', function (?User $user) {
            return $user?->is_admin && !$user?->blocked;
        });
        Gate::define('update-skill', function (User $user) {
            return $user->is_admin && !$user->blocked;
        });
        Gate::define('delete-skill', function (User $user) {
            return $user->is_admin && !$user->blocked;
        });

        Gate::define('create-field', function (User $user) {
            return $user->is_admin && !$user->blocked;
        });
        Gate::define('update-field', function (User $user) {
            return $user->is_admin && !$user->blocked;
        });
        Gate::define('delete-field', function (User $user) {
            return $user->is_admin && !$user->blocked;
        });

        Gate::define('update-subject', function (User $user) {
            return $user->is_admin && !$user->blocked;
        });

        Gate::define('update-group', function (User $user) {
            return $user->is_admin && !$user->blocked;
        });

        Gate::define('update-type', function (User $user) {
            return $user->is_admin && !$user->blocked;
        });

        Gate::define('create-checkpoint', function (?User $user) {
            return !$user?->blocked || $user == null;
        });
        Gate::define('preview-checkpoint', function (?User $user, Checkpoint $checkpoint) {
            return (!$user?->blocked || $user == null) && (($checkpoint->is_public && !$checkpoint->is_update) || (!$checkpoint->is_public && (!empty($user) && $user->id == $checkpoint->author->id)) || (!empty($user) && $user->is_admin));
        });
        Gate::define('record-checkpoint', function (?User $user, Checkpoint $checkpoint) {
            return (!$user?->blocked || $user == null) && (($checkpoint->is_public && !$checkpoint->is_update) || (!$checkpoint->is_public && (!empty($user) && $user->id == $checkpoint->author->id)) || (!empty($user) && $user->is_admin));
        });
        Gate::define('update-checkpoint', function (User $user, ?Checkpoint $checkpoint) {
            return $checkpoint != null ? !isset($checkpoint->potential_replacement) && (($user->id === $checkpoint->author?->id) && !$user->blocked || $user->is_admin && !$user->blocked) : $user->is_admin && !$user->blocked;
        });
        Gate::define('see-checkpoint-update-path', function (User $user, ?Checkpoint $checkpoint) {
            return $checkpoint != null ? (($user->id === $checkpoint->author?->id) && !$user->blocked || $user->is_admin && !$user->blocked) : $user->is_admin && !$user->blocked;
        });
        Gate::define('delete-checkpoint', function (User $user, ?Checkpoint $checkpoint) {
            return $checkpoint != null ? ($user->id === $checkpoint->author?->id) && !$user->blocked || $user->is_admin && !$user->blocked : $user->is_admin && !$user->blocked;
        });

        Gate::define('delete-checkpoint-session', function (User $user, ?UserCheckpointSession $session) {
            return $session != null ? ($user->id === $session->author?->id) && !$user->blocked || $user->is_admin && !$user->blocked : $user->is_admin && !$user->blocked;
        });
    }
}
