<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{mix('vendor/larabek/app.css')}}">
    <title>Larabek</title>
</head>
<body>
<div id="admin">Larabek is loading</div>
<script>
    window.ADMIN_PREFIX = '@php(print(config('admin.route_prefix')))'
</script>
<script src="{{mix('vendor/larabek/app.js')}}"></script>
</body>
</html>
