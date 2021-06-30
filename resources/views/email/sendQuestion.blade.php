<!DOCTYPE html>
<html>
<head>
    <title>ответ на заявку #{{$qId}}</title>
</head>
<body>
<h1>Добрый день, {{ $qName }}</h1>
<p>Вы добавили заявку: #{{ $qId }}</p>
<p>Ваше сообщение:</p>
<p style="color: #0544bc;">{{ $qMessage }} </p>
<p style="color: rgba(241,0,0,0.93);">{{ $qDateTime }}, Вам ответили:</p>
<p style="color: rgba(241,0,0,0.93);">{{ $qComment }}</p>
<p>Статус: {{ $qStatus }}</p>
<p>Спасибо за обращение.</p>
</body>
</html>
