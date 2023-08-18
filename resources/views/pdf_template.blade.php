<!DOCTYPE html>
<html>
<head>
    <title>PDF Document</title>
</head>
<body>
    <h1>{{ $document['name'] }}</h1>
    <ul>
        @foreach($document['values'] as $param)
            @foreach($param as $key => $value)
                <li>{{ $key }}: {{ $value }}</li>
            @endforeach
        @endforeach
    </ul>
</body>
</html>
