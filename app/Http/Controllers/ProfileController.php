<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Facades\Spatie\Referer\Referer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, User $profile)
    {
        $this->authorize('update-profile', [$profile]);
        return view('profile.edit', [
            'user' => $profile
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request)
    {
        $this->authorize('update-profile', [User::find($request->route()->parameter('profile'))]);
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit', $request->user())->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, User $profile)
    {
        $this->authorize('delete-profile', [$profile]);
        if (!$request->user()->is_admin) {
            $request->validateWithBag('userDeletion', [
                'password' => ['required', 'current-password'],
            ]);
        }
        $user = $profile;
        if ($request->user()->id == $profile->id) {
            Auth::logout();
        }

        $user->delete();

        if ($request->user()->id == $profile->id) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
        $profile = null;
        return Redirect::to('/');
    }

    public function block(User $profile)
    {
        $profile->blocked = 1;
        $profile->save();
        return redirect(Referer::get());
    }

    public function unblock(User $profile)
    {
        $profile->blocked = 0;
        $profile->save();
        return redirect(Referer::get());
    }
}
