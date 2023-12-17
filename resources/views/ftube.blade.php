<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ftube</title>
</head>
<body style="background: #23272e;">
    
    @include('layouts.navbar')

<div class="container">
    <div class="row">
        @foreach ($videos['items'] as $video)
            <div class="col-sm-6 col-md-4">
                <iframe 
                    width="441"
                    height="248" 
                    src="https://www.youtube.com/embed/{{ $video['id'] }}"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
