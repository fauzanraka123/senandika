<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat mengikuti diri sendiri.');
        }

        auth()->user()->following()->syncWithoutDetaching($user->id);

        return back()->with('success', 'Anda sekarang mengikuti ' . $user->name);
    }

    public function unfollow(User $user)
    {
        auth()->user()->following()->detach($user->id);

        return back()->with('success', 'Anda telah berhenti mengikuti ' . $user->name);
    }
}
