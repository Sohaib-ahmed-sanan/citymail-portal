<!DOCTYPE html>
<html>
<head>
    <title>Orio Express</title>
</head>
<body>
    <h1>{{ $mailData['title'] }}</h1>  
    <p>{!! $mailData['body'] !!}</p>
    <a href="{{ $mailData['link'] }}" target="_blank">Recover Password</a>     
    <p>Thank you</p>
</body>
</html>