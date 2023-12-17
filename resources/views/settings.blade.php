@php

use Illuminate\Support\Facades\Auth;
use App\Models\UserFollowers;
use App\Models\Posts;

@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
</head>
<body>

    @include('layouts.navbar')

    <section class="h-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-9 col-xl-7">
                    <div class="card">
                        <div class="rounded-top text-white d-flex flex-row" style="background-color: #000; height:200px;">
                            <div class="ms-4 d-flex flex-column" style="width: 150px;">
                                @if(Auth::user()->avatar !== NULL)
                                    <img src="{{ asset('/storage/users-avatar/' . auth()->user()->avatar) }}"
                                        alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                                        style="object-fit: cover; z-index: 1" width="150" height="150">
                                @else
                                    <img src="{{ asset('images/default/profile.webp') }}"
                                    alt="Generic placeholder image" class="img-fluid img-thumbnail mt-4 mb-2"
                                    style="width: 150px; z-index: 1">
                                @endif
                            </div>
                            <div class="ms-3" style="margin-top: 130px;">
                                <h5>{{ Auth::user()->name }}</h5>
                            </div>
                        </div>
                        <div class="p-4 text-black" style="background-color: #f8f9fa;">
                            <div class="d-flex justify-content-end text-center py-1">
                                <div>
                                    <p class="mb-1 h5">{{ count(Posts::where('created_by', $user->id)->get()) }}</p>
                                    <p class="small text-muted mb-0">Posts</p>
                                </div>
                                <div class="px-3">
                                    <a href="{{ route('user.followers') }}" class="mb-1 h5 text-decoration-none">{{ count(UserFollowers::where(['follow_to' => Auth::user()->id])->get()) }}</a>
                                    <p class="small text-muted mb-0">Followers</p>
                                </div>
                                <div>
                                    <a href="{{ route('user.followings') }}" class="mb-1 h5 text-decoration-none">{{ count(UserFollowers::where(['origin_user' => Auth::user()->id])->get()) }}</a>
                                    <p class="small text-muted mb-0">Following</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4 text-black" style="background-color: #d3d3d3;">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <p class="lead fw-normal mb-0">Recent photos</p>
                                <!-- <p class="mb-0"><a href="#!" class="text-muted">Show all</a></p> -->
                            </div>
                            @if(count(Posts::where('created_by', Auth::user()->id)->get()) === 0)
                                <div class="row g-2">
                                    Nothing posted yet
                                </div>
                            @else
                                @php $posts = Posts::where('created_by', Auth::user()->id)->orderBy('created_at', 'DESC')->take(4)->get(); @endphp
                                <div class="row g-2">
                                    @foreach($posts as $post)
                                        @php
                                            $productFolder = public_path('assets/' . $post->id);
                                                if (is_dir($productFolder)) {
                                                    $images = scandir($productFolder);
                                                    $imageTags = [];
                                                    foreach ($images as $image) {
                                                        if (!in_array($image, ['.', '..']) && is_file($productFolder . '/' . $image)) {
                                                            $imageTags[] = '
                                                                <img class="w-100 rounded-3" width="320" height="220" src="' . asset('assets/' . $post->id . '/' . $image) . '"/>
                                                            ';
                                                        }
                                                    }
                                                }
                                        @endphp
                                        <div class="col-6 mb-2">
                                            {!! $imageTags[0] !!}
                                        </div>
                                    @endforeach
                                </>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>
