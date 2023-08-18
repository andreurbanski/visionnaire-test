@extends('layout')

@section('content')
<div class="container">
    <h1>List of Documents</h1>

    <!-- Button to trigger the modal -->
    <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#documentModal">Create New Document</button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Values</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $document)
            <tr>
                <td>{{ $document->id }}</td>
                <td>{{ $document->name }}</td>
                <td>
                    @if(!empty($document->values))
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Key</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(json_decode($document->values, true) as $param)
                                    @php
                                        $key = key($param);
                                        $value = reset($param);
                                    @endphp
                                    <tr>
                                        <td>{{ $key }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        No values for this document
                    @endif
                </td>
                <td>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#documentModal{{ $document->id }}">Edit</button>
                    <button class="btn btn-danger btn-sm">Delete</button>
                    <a href="#" class="btn btn-success btn-sm">Generate PDF</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal for creating/editing documents -->
    <div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel" aria-hidden="true">
        <!-- Modal content goes here -->
    </div>

    @foreach($documents as $document)
    <div class="modal fade" id="documentModal{{ $document->id }}" tabindex="-1" role="dialog" aria-labelledby="documentModalLabel{{ $document->id }}" aria-hidden="true">
        <!-- Modal content goes here -->
    </div>
    @endforeach
</div>
@endsection
