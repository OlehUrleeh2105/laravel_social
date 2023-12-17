<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ftube</title>

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container-slides {
            width: 100%;
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
        }

        .slides{
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 50px;
            color: #fff;
            background: #23272e;
            scroll-snap-align: start;
        }

        .slides iframe {
            width: 348px;
            border-radius: 15px
        }
    </style>
</head>
<body>
    <div class="container-slides">
        @foreach($videos['items'] as $video)
            <div class="slides">
                <iframe width="348" height="619"
                    src="https://www.youtube.com/embed/{{ $video['id']['videoId'] }}?loop=1"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media;
                    gyroscope; picture-in-picture; web-share"
                    autoplay muted playsinline loop 
                    >
                </iframe>
            </div>
        @endforeach
    </div>

</body>
</html>