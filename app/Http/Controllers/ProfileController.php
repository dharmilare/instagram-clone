<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;


class ProfileController extends Controller
{


    public function index(User $user)
    {
        $follows=(auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postCount=Cache::remember('count.posts.' . $user->id, now()->addSeconds(30), function() use ($user) {
            return $user->posts->count();
        });
        $followersCount=Cache::remember('count.followers.' . $user->id, now()->addSeconds(30), function() use ($user) {
            return $user->profile->followers->count();
        });
        $followingCount=Cache::remember('count.following.' . $user->id, now()->addSeconds(30), function() use ($user) {
            return $user->following->count();
        });

        return view('profile.index', compact('user','follows','postCount', 'followersCount', 'followingCount'));
    }


   public function edit(User $user)
   {
       $this->authorize('update', $user->profile);

        return view('profile.edit', compact('user'));
   }


   public function update(User $user)
   {
    $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title'=>'required',
            'description'=>'required',
            'url'=>'',
            'image'=>'',
        ]); 

        if(request('image')){
            $imagePath= request('image')->store('profile','public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(50,50);
            $image->save();

            $ImageArray= ['image'=>$imagePath];

     
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $ImageArray ?? []
        ));

        return redirect("/profile/{$user->id}");
   }
}
