<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>视频网站</title>
</head>
<body>
    @if($data['status']==1)
        <h1>{{$data['id']}}</h1>
        <hr>
        <video src="https://video-1258120694.cos.ap-beijing.myqcloud.com/{{$data['id']}}" controls="controls"></video>
    @else
        <h1>{{$data['name']}}</h1>
        <hr>
        <video src="/{{$data['path']}}" controls="controls"></video>
    @endif
</body>
</html>