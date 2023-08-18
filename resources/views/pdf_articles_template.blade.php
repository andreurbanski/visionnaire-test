<!DOCTYPE html>
<html>
<head>
    <title>ARTICLE DOCUMENT</title>
</head>
<body>
    <h1>ARTICLE - {{ $document['name'] }}</h1>
    <ul>
        @foreach($document['values'] as $param)
            @foreach($param as $key => $value)
                <li>{{ $key }}: {{ $value }}</li>
            @endforeach
        @endforeach
    </ul>
</body>
</html>
