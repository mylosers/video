<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>视频网站</title>
</head>
<body>
    <h1>{{$data['name']}}</h1>
    <hr>
    <video src="/{{$data['path']}}" controls="controls"></video>
</body>
</html>