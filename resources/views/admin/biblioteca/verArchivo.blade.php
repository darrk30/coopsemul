<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   
    <iframe src="{{ Storage::disk('s3')->url($urlArchivo) }}"  frameborder="0" style="width: 100%; height: 100vh;"></iframe>
</body>
</html>
