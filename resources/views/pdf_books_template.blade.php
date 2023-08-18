<!DOCTYPE html>
<html>
<head>
    <title>BOOK TEMPLATE</title>
</head>
<body>
    <h1>BOOK - {{ $document['name'] }}</h1>
    <ul>
        @foreach($document['values'] as $param)
            @foreach($param as $key => $value)
                <li>{{ $key }}: {{ $value }}</li>
            @endforeach
        @endforeach
    </ul>
</body>
</html>
