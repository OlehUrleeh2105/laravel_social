@php use App\Models\Posts; @endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <style>
        body{
            background:#DCDCDC;
            margin-top:20px;
        }
        .card-box {
            padding: 20px;
            border-radius: 3px;
            margin-bottom: 30px;
            background-color: #fff;
        }

        .social-links li a {
            border-radius: 50%;
            color: rgba(121, 121, 121, .8);
            display: inline-block;
            height: 30px;
            line-height: 27px;
            border: 2px solid rgba(121, 121, 121, .5);
            text-align: center;
            width: 30px
        }

        .social-links li a:hover {
            color: #797979;
            border: 2px solid #797979
        }
        .thumb-lg {
            height: 88px;
            width: 88px;
        }
        .img-thumbnail {
            padding: .25rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            max-width: 100%;
            height: auto;
        }
        .text-pink {
            color: #ff679b!important;
        }
        .btn-rounded {
            border-radius: 2em;
        }
        .text-muted {
            color: #98a6ad!important;
        }
        h4 {
            line-height: 22px;
            font-size: 18px;
        }
    </style>

    <title>Document</title>
</head>
<body style="background: #babab8;">

@include('layouts.navbar')

<div class="content mt-3">
    <div class="container">
        <div class="row">
            @foreach($users as $user)
                <div class="col-lg-4">
                    <div class="text-center card-box">
                        <div class="member-card pt-2 pb-2">
                            @if($user->avatar !== NULL)
                                <div class="thumb-lg member-thumb mx-auto"><img src="{{ asset('/storage/users-avatar/' . $user->avatar) }}" style="border: 1px solid #dee2e6; border-radius: .25rem;" class="rounded-circle" width="70" height="70" alt="profile-image"></div>
                            @else
                                <div class="thumb-lg member-thumb mx-auto"><img src="{{ asset('images/default/profile.webp') }}" style="border: 1px solid #dee2e6; border-radius: .25rem;" class="rounded-circle" width="70" height="70" alt="profile-image"></div>
                            @endif
                            <div class="mt-1">
                                <h4>{{ $user->name }}</h4>
                            </div>
                            <a href="/chatify/{{ $user->id }}" class="btn btn-primary mt-1 btn-rounded waves-effect w-md waves-light">Message Now</a>
                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mt-3">
                                            <h4>{{ count(Posts::where('created_by', $user->id)->get()) }}</h4>
                                            <p class="mb-0 text-muted">Posts</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-3">
                                            <h4>{{ $user->followers_count }}</h4>
                                            <p class="mb-0 text-muted">Followers</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-3">
                                            <h4>{{ $user->followings_count }}</h4>
                                            <p class="mb-0 text-muted">Followings</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
</body>
</html>