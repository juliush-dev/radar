<?php

namespace App\Providers;


use App\Models\LearningMaterial;
use App\Models\Topic;
use App\Models\User;
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
        Gate::define('assess-topic', function (User $user) {
            return !$user->blocked;
        });

        Gate::define('update-topic', function (User $user, ?Topic $topic) {
            return $topic != null ? !isset($topic->updating_topic_id) && (($user->id === $topic->author?->id) && !$user->blocked || $user->is_admin && !$user->blocked) : $user->is_admin && !$user->blocked;
        });

        Gate::define('see-topic-update-path', function (User $user, ?Topic $topic) {
            return $topic != null ? (($user->id === $topic->author?->id) && !$user->blocked || $user->is_admin && !$user->blocked) : $user->is_admin && !$user->blocked;
        });

        Gate::define('delete-topic', function (User $user, ?Topic $topic) {
            return $topic != null ? ($user->id === $topic->author?->id) && !$user->blocked || $user->is_admin && !$user->blocked : $user->is_admin && !$user->blocked;
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
    }
}
