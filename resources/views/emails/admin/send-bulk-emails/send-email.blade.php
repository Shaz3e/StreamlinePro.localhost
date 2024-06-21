<!DOCTYPE html>
<html>
<head>
    <title>{{ $email->subject }}</title>
</head>
<body>
    {!! $email->content !!}
</body>
</html>