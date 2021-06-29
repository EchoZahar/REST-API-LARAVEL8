<!DOCTYPE html>
<html>
<head>
    <title>Вами создана заявка #{{$qId}}</title>
</head>
<body>
    <h1>Добрый день, {{ $qName }}</h1>
    <p>Вы добавили заявку: #{{ $qId }}</p>
    <p>Ваше сообщение:</p>
    <p style="color: #0544bc;">{{ $qMessage }} </p>
    <p style="color: rgba(241,0,0,0.93);"> Ответ Вы получите так-же сообщением, в ближайщее время.</p>
</body>
</html>
