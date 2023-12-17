@php

use Illuminate\Support\Carbon;

use App\Models\User;
use App\Models\Comments;
use App\Models\PostLikes;
use App\Models\UserFollowers;

@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .profileImgSm {
            border-radius: 75px;
            max-width: 20px;
        }
    </style>

</head>

<body>

    @include('layouts.navbar')

    <div class="container instaFeedBodyWrap">
        <div class="row g-5">
            <div class="col-sm-8">
                @if(count($posts->toArray()) === 0)
                <div class="d-flex justify-content-center text-center">
                    <h1>You haven't postsed something yet</h1>
                </div>
                @endif

                @foreach($posts as $post)
                <div class="mx-auto">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                @php
                                $user_created = User::find($post->created_by);
                                @endphp

                                <div class="d-flex align-items-center">
                                    @if($user_created->avatar !== NULL)
                                    <img src="{{ asset('/storage/users-avatar/' . $user_created->avatar) }}" class="rounded-circle" width="30" height="30">
                                    @else
                                    <img src="{{ asset('images/default/profile.webp') }}" class="rounded-circle" width="30" height="30">
                                    @endif
                                    <h6 class="mb-0 ms-2" data-bs-toggle="popover" data-bs-trigger="hover focus" title="<div class='d-flex'><img src='justinProfile.png' class='profileImage'> <div class='ms-2'><div>Justin Bieber</div><div>Sub-text</div></div>" data-bs-content="And here's some amazing content. It's very engaging. Right?">{{ $user_created->name }}</h6>
                                </div>
                                <div data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Disabled popover">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @php
                            $productFolder = public_path('assets/' . $post->id);
                            if (is_dir($productFolder)) {
                            $images = scandir($productFolder);
                            $imageTags = [];
                            foreach ($images as $image) {
                            if (!in_array($image, ['.', '..']) && is_file($productFolder . '/' . $image)) {
                            $imageTags[] = '
                            <img class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" src="' . asset('assets/' . $post->id . '/' . $image) . '" />
                            ';
                            }
                            }
                            }
                            @endphp
                            @if(count($imageTags) > 1)
                            <div id="carouselExampleFade_{{ $post->id }}" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($imageTags as $key => $image)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                        {!! $image !!}
                                    </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade_{{ $post->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade_{{ $post->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            @else
                            {!! $imageTags[0] !!}
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    @auth
                                    @php $liked = PostLikes::where(['user_id' => Auth::user()->id, 'post_id' => $post->id])->first(); @endphp

                                    <a href="{{ route('user.add.like', ['id' => $post->id]) }}" class="text-decoration-none">
                                        @if($liked)
                                        <i class="fa-solid fa-heart fa-lg text-danger"></i>
                                        @else
                                        <i class="fa-regular fa-heart fa-lg text-danger"></i>
                                        @endif
                                    </a>

                                    <a href="{{ route('post.comments', ['id' => $post->id]) }}" class="text-decoration-none">
                                        <i class="fa-regular fa-message fa-lg mx-3"></i>
                                    </a>
                                    @endauth
                                </div>
                            </div>
                            <div>
                                <div>
                                    <b>{{ $user_created->name }}:</b> {{ $post->content }}
                                </div>

                                @php $comments = Comments::where('post_id', $post->id)->get(); @endphp

                                @if(count($comments) > 2)
                                <div class="text-secondary">
                                    <a class="text-decoration-none text-secondary" href="{{ route('post.comments', ['id' => $post->id]) }}">View all {{ count($comments) }} comments</a>
                                </div>
                                @endif

                                @foreach(array_slice($comments->toArray(), 0, 2) as $comment)
                                <div>
                                    @php $user_commented = User::find($comment['user_id']); @endphp
                                    <b>{{ $user_commented->name }}:</b> {{ $comment['content'] }}
                                </div>
                                @endforeach
                            </div>
                            <div>
                                @php $diff = $post->created_at->diffInDays(now()); @endphp
                                <small class="text-secondary">Posted: {{ $diff === 0 ? "TODAY" : $diff . " DAY(S) AGO"  }}</small>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                @auth
                                <form method="POST" action="{{ route('user.add.comment', ['id' => $post->id]) }}">
                                    @csrf
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <input type="text" name="content" class="form-control">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa-solid fa-share"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @auth
                <hr />

                @foreach($additional_posts as $post)
                <div class="mx-auto">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex align-items-center justify-content-between">
                                @php
                                $user_created = User::find($post->created_by);
                                @endphp

                                <div class="d-flex align-items-center">
                                    @if($user_created->avatar !== NULL)
                                    <img src="{{ asset('/storage/users-avatar/' . $user_created->avatar) }}" class="rounded-circle" width="30" height="30">
                                    @else
                                    <img src="{{ asset('images/default/profile.webp') }}" class="rounded-circle" width="30" height="30">
                                    @endif
                                    <h6 class="mb-0 ms-2" data-bs-toggle="popover" data-bs-trigger="hover focus" title="<div class='d-flex'><img src='justinProfile.png' class='profileImage'> <div class='ms-2'><div>Justin Bieber</div><div>Sub-text</div></div>" data-bs-content="And here's some amazing content. It's very engaging. Right?">{{ $user_created->name }}</h6>
                                </div>
                                <div data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="Disabled popover">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            @php
                            $productFolder = public_path('assets/' . $post->id);
                            if (is_dir($productFolder)) {
                            $images = scandir($productFolder);
                            $imageTags = [];
                            foreach ($images as $image) {
                            if (!in_array($image, ['.', '..']) && is_file($productFolder . '/' . $image)) {
                            $imageTags[] = '
                            <img class="bd-placeholder-img bd-placeholder-img-lg d-block w-100" width="800" height="400" src="' . asset('assets/' . $post->id . '/' . $image) . '" />
                            ';
                            }
                            }
                            }
                            @endphp
                            @if(count($imageTags) > 1)
                            <div id="carouselExampleFade_{{ $post->id }}" class="carousel slide carousel-fade" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach($imageTags as $key => $image)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                        {!! $image !!}
                                    </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade_{{ $post->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade_{{ $post->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                            @else
                            {!! $imageTags[0] !!}
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div>
                                    @auth
                                    @php $liked = PostLikes::where(['user_id' => Auth::user()->id, 'post_id' => $post->id])->first(); @endphp

                                    <a href="{{ route('user.add.like', ['id' => $post->id]) }}" class="text-decoration-none">
                                        @if($liked)
                                        <i class="fa-solid fa-heart fa-lg text-danger"></i>
                                        @else
                                        <i class="fa-regular fa-heart fa-lg text-danger"></i>
                                        @endif
                                    </a>
                                    @endauth
                                </div>
                            </div>
                            <div>
                                <div>
                                    <b>{{ $user_created->name }}:</b> {{ $post->content }}
                                </div>

                                @php $comments = Comments::where('post_id', $post->id)->get(); @endphp

                                @if(count($comments) > 2)
                                <div class="text-secondary">
                                    <a class="text-decoration-none text-secondary" href="{{ route('post.comments', ['id' => $post->id]) }}">View all {{ count($comments) }} comments</a>
                                </div>
                                @endif

                                @foreach(array_slice($comments->toArray(), 0, 2) as $comment)
                                <div>
                                    @php $user_commented = User::find($comment['user_id']); @endphp
                                    <b>{{ $user_commented->name }}:</b> {{ $comment['content'] }}
                                </div>
                                @endforeach
                            </div>
                            <div>
                                @php $diff = $post->created_at->diffInDays(now()); @endphp
                                <small class="text-secondary">Posted: {{ $diff === 0 ? "TODAY" : $diff . " DAY(S) AGO"  }}</small>
                            </div>
                            <div class="d-flex align-items-center mt-3">
                                @auth
                                <form method="POST" action="{{ route('user.add.comment', ['id' => $post->id]) }}">
                                    @csrf
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <input type="text" name="content" class="form-control">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa-solid fa-share"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-center text-decoration-none mb-4">
                    {{ $additional_posts->links() }}
                </div>
                @endauth
            </div>
            <div class="col-sm-4">
                <div style="background-color: #d3d3d3;" class="rounded-3 p-3">
                    <div>
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="fw-bold">Suggestions For You</div>
                        </div>
                        @foreach($users as $user)
                        <div class="d-flex align-items-center justify-content-between my-2">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    @if($user->avatar !== NULL)
                                    <img src="{{ asset('/storage/users-avatar/' . $user->avatar) }}" class="rounded-circle" width="40" height="40">
                                    @else
                                    <img src="{{ asset('images/default/profile.webp') }}" class="rounded-circle" width="40" height="40">
                                    @endif
                                </div>
                                <div>
                                    <div>{{ $user->name }}</div>

                                    @php
                                    $created_at = Carbon::parse($user->created_at);

                                    $currDate = Carbon::now();

                                    $diff = $currDate->diffInDays($created_at);
                                    @endphp

                                    @if($diff <= 7) <div>
                                        <small class="text-secondary">New in php social network</small>
                                </div>
                                @endif
                            </div>
                        </div>
                        @auth
                        @php $subscribed = UserFollowers::where(['origin_user' => Auth::user()->id, 'follow_to' => $user->id])->first(); @endphp

                        @if($subscribed)
                        <a href="{{ route('user.follow', ['id' => $user->id]) }}" class="text-secondary text-decoration-none">
                            Followed by you
                        </a>
                        @else
                        <a href="{{ route('user.follow', ['id' => $user->id]) }}" class="text-primary text-decoration-none">
                            Follow
                        </a>
                        @endif
                        @endauth
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>

</body>

</html>
