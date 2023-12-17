<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add post</title>
</head>
<body>

    @include('layouts.navbar')

    <div class="container mt-4 p-3 rounded-3" style="background-color: #d3d3d3;">
        <h3 class="text-center">Add a New Post</h3>
        <form class="mt-2" method="POST" action="{{ route('user.added.post') }}"  enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <textarea class="form-control" id="content" name="content" placeholder="Content" required></textarea>
            </div>

            <div class="mt-2 mb-3">
                <label for="images" class="form-label">Post Images</label>
                <input type="file" class="form-control form-control-sm" name="images[]" multiple required>
            </div>

            <button type="submit" class="btn btn-primary">Add Post</button>
        </form>
    </div>

</body>
</html>
