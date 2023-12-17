<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\UserFollowers;
use App\Models\User;

class UserFollowsController extends Controller
{
    public function onFollow(Request $request) {
        $origin_user = Auth::user()->id;
        $user_follow = $request->id;
        
        $followed = UserFollowers::where([
            'origin_user' => $origin_user, 
            'follow_to' => $user_follow,
        ])->first();

        if($followed) {
            $followed->delete();
        } else {
            UserFollowers::create([
                'origin_user' => $origin_user,
                'follow_to' => $user_follow,
            ]);
        }

        return redirect()->back();
    }

    public function onUserFollowing(){
        $auth_user = Auth::user();

        $users = [];
        $uf = UserFollowers::where('origin_user', $auth_user->id)->get();

        foreach($uf as $follower) {
            $user = User::find($follower->follow_to);

            $user->followings_count = count(UserFollowers::where(['follow_to' => $user->id])->get());
            $user->followers_count =  count(UserFollowers::where(['origin_user' => $user->id])->get());
            
            $users[] = $user;
        }

        if(count($users) === 0) {
            return redirect()->back();
        }

        return view('followers', ['users' => $users]);
    }

    public function onUserFollowers() {
        $auth_user = Auth::user();

        $users = [];
        $uf = UserFollowers::where('follow_to', $auth_user->id)->get();

        foreach($uf as $follower) {
            $user = User::find($follower->origin_user);

            $user->followers_count = count(UserFollowers::where(['origin_user' => $user->id])->get());
            $user->followings_count =  count(UserFollowers::where(['follow_to' => $user->id])->get());
            
            $users[] = $user;
        }

        if(count($users) === 0) {
            return redirect()->back();
        }

        return view('followers', ['users' => $users]);
    }
}
