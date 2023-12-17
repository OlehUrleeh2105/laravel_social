@php
    use App\Models\User;
@endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @media(min-width:568px){
            .end{
                margin-left: auto;
            }
        }

        @media(max-width:768px){
            #post{
                width: 100%;
            }
        }

        #profile{
            background-color: unset;

        }

        #post{
            margin: 10px;
            padding: 6px;
            padding-top: 2px;
            padding-bottom: 2px;
            text-align: center;
            background-color: green;
            color: white;
            border-width: 1px;
            border-style: solid;
            border-radius: 13px;
            width: 50%;
        }

        body{
            background-color: black;
        }

        #nav-items li a,#profile{
            text-decoration: none;
            color: rgb(224, 219, 219);
            background-color: black;
        }


        .comments{
            margin-top: 5%;
            margin-left: 20px;
        }

        .darker{
            border: 1px solid #ecb21f;
            background-color: black;
            float: right;
            border-radius: 5px;
            padding-left: 40px;
            padding-right: 30px;
            padding-top: 10px;
        }

        .comment{
            background-color: #6c757d;
            float: left;
            border-radius: 5px;
            padding-left: 40px;
            padding-right: 30px;
            padding-top: 10px;

        }
        .comment h4,.comment span,.darker h4,.darker span{
            display: inline;
        }

        .comment p,.comment span,.darker p,.darker span{
            color: rgb(184, 183, 183);
        }

        h1,h4{
            color: white;
            font-weight: bold;
        }
        label{
            color: rgb(212, 208, 208);
        }

        #align-form{
            margin-top: 20px;
        }
        .form-group p a{
            color: white;
        }

        #darker img{
            margin-right: 15px;
            position: static;
        }

        .form-group input,.form-group textarea{
            background-color: white;
            border: 1px solid rgba(16, 46, 46, 1);
            border-radius: 12px;
        }

        .comment-form{
            background-color: #6c757d;
            border-radius: 5px;
            padding: 20px;
        }
    </style>

    <title>Document</title>
</head>
<body>
    @include('layouts.navbar')

    <section class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-5 col-md-6 col-12 pb-4">
                    <h1>Comments</h1>
                    @foreach($comments as $comment)
                        <div class="comment mt-4 text-justify float-left w-100">
                            @php $user = User::find($comment->user_id); @endphp

                            @if($user->avatar !== NULL)
                                <img src="{{ asset('/storage/users-avatar/' . $user->avatar) }}" class="rounded-circle me-1" width="40" height="40">
                            @else
                                <img src="{{ asset('images/default/profile.webp') }}" class="rounded-circle me-1" width="40" height="40">
                            @endif


                            <h4 class="text-white ml-2 align-middle">{{ $user->name }}</h4>
                            <span class="ml-2 align-middle">- {{ date("j F, Y", strtotime($comment->created_at)) }}</span>

                            <div class="mt-2">
                                <p class="text-white">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-4 col-md-5 col-sm-4 offset-md-1 offset-sm-1 col-12 mt-4">
                    <form id="algin-form" class="comment-form" method="POST" action="{{ route('user.add.comment', ['id' => request('id')]) }}">
                        @csrf
                        <div class="form-group">
                            <h4 class="text-white">Leave a comment</h4>
                            <label for="message">Message</label>
                            <textarea name="content" id=""msg cols="30" rows="5" class="form-control" style="background-color: gray; color: white;"></textarea>
                        </div>
                        <div class="text-center">
                            <div class="form-group">
                                <button type="submit" id="post" class="btn">Post Comment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
