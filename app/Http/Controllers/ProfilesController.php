<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        // get activities with subject property, take only 50 records and group by record with date with format Y-m-d
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $this->getActivity($user)
        ]);
    }

    /**
     * @param User $user
     * @return mixed
     */
    protected function getActivity(User $user)
    {
        return $user->activities()->with('subject')->latest()->take(50)->get()->groupBy(function ($activity) {
            return $activity->created_at->format('Y-m-d');
        });
    }
}
