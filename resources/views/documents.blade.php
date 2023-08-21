@extends('layout')

@section('content')
<div class="container">
    <h1>List of Documents</h1>

    <!-- Button to trigger the modal -->
    <button class="btn btn-primary mb-2 btn_new_document">Create New Document</button>

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
                                @foreach($document->values as $param)
                                    <tr>
                                        <td>{{ key($param) }}</td>
                                        <td>{{ reset($param) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        No values for this document
                    @endif
                </td>
                <td>
                    <button class="btn btn-primary btn-sm btn-edit" data-document='{{$document}}'>Edit</button>
                    <button class="btn btn-danger btn-sm btn_delete_document" data-document='{{$document}}'>Delete</button>
                    <a href="{{route('generate_pdf', $document->id )}}" class="btn btn-success btn-sm">Generate PDF</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

  
  <!-- Modal -->
  <div class="modal fade" id="documentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="documentModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-store-body">
          <table>
            <tr>
                <th>Field</th><th>Value</th>
            </tr>
            <tbody id='tbody-document-fields'>
                <tr>
                    <td>
                        Document Name
                    </td>
                    <td>
                        <input type='text' name='name' id='name' class='form-control'>
                        <input type='hidden' name='id' id='id' class='form-control'>
                    </td>
                </tr>    
                <tr>
                    <td>
                        Document Type
                    </td>
                    <td>
                       <select class='form-control' id='type_id'>
                            <option value='empty'>Select one type</option>
                            @foreach($types as $type)
                                <option value='{{$type->id}}'>{{$type->name}}</option>
                            @endforeach
                       </select>
                    </td>
                </tr>  
                <tr>
                    <td style='text-align: center'><h3 style='width: 100%'>Documents Values</h3></td>
                </tr>
                <tr>
                    <td>
                        <input type='text' name='key0' id='key0' class='form-control'>
                    </td>
                    <td>
                        <input type='text' name='value0' id='value0' class='form-control'>
                    </td>
                </tr> 
            </tbody>
            <tbody id='tbody_adicional_fields'> 
            </tbody>    
                
          </table>
        </div>

        <div class="modal-store-success" style='display: none'>
            <div class="alert alert-success" role="alert">
                <h6>The document was successfully saved.</h6>
            </div> 
            
        </div>
        <div class="modal-store-fail" style='display: none'>
            <div class="alert alert-danger" role="alert">
                <h6>Something went wrong trying to save this document. Try again later.</h6>
            </div> 
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-success btn-add-fields left">Add Extra Field</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id='documentModalSubmitButton' data-resource=''>Save changes</button>
        </div>
      </div>
    </div>
  </div>



  <!-- Modal -->
  <div class="modal fade" id="documentDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="documentDeleteModalLabel">Remove Document</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-delete-body">
          <h6>Are you sure you want to destroy the document</h6> 
            <h3><label id='modal_destroy_document_name' style='color: red'></label></h3>
        </div>
        <div class="modal-delete-success" style='display: none'>
            <div class="alert alert-success" role="alert">
                <h6>The document was successfully deleted.</h6>
            </div> 
            
        </div>
        <div class="modal-delete-fail" style='display: none'>
            <div class="alert alert-danger" role="alert">
                <h6>Something went wrong trying to delete this document. Try again later.</h6>
            </div> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger" id='documentDeleteModalSubmitButton' data-resource=''>DESTROY</button>
        </div>
      </div>
    </div>
  </div>

  <script>

    var storeRoute = "{{route('store')}}"
    var updateRoute = "{{ route('update') }}"
    var deleteRoute = "{{ route('destroy', '%document_id%') }}"

   $('.btn-add-fields').on('click', function (e) {
        e.preventDefault
        last_field = 0;
        for (i= 0; $("#key" + i).length; i++) {
            last_field = i;
        }
        
        add_custom_field(last_field+1)
   });

    function add_custom_field(index = 0) {
            field_html = "<tr>"
                            +"<td>"
                            +    "<input type='text' name='key"+ index + "' id='key"+ index + "' class='form-control'>"
                            +"</td>"
                            +"<td>"
                            +    "<input type='text' name='value"+ index + "' id='value"+ index + "' class='form-control'>"
                            +" </td>"
                        +"</tr>  "
            $("#tbody_adicional_fields").append(field_html);
            $('#type_select').val('empty')
    }

    function reset_save_fields() {
            $("#tbody_adicional_fields").empty();
            $("#name").val('');
            $("#id").val('');
            $("#key0").val('');
            $("#value0").val('');
    }

    $(".btn-edit").on("click", function() {
        const doc = $(this).data().document;
        reset_save_fields()
        $('#name').val(doc.name);
        $('#id').val(doc.id);
        $('#type_id').val(parseInt(doc.type_id))


        doc.values.forEach( (element, index) => {
            if(!$("#key" + index).length){
                add_custom_field(index);
            }
            key = Object.keys(element)[0];
            $("#key" + index).val(key);
            $("#value" + index).val(element[key]);
            console.log(element)
        });



        $('#documentModalLabel').text('Edit Document');
        $('#documentModalSubmitButton').data('resource', updateRoute);
        $('#documentModalSubmitButton').data('method', 'PATCH');
        $('#documentModal').modal('show');

    });

    $(".btn_new_document").on("click", function() {
        reset_save_fields()

        $('#documentModalLabel').text('Create New Document');
        $('#documentModalSubmitButton').data('resource', storeRoute);
        $('#documentModalSubmitButton').data('method', 'POST');
        $('#documentModal').modal('show');

    });

    $(".btn_delete_document").on("click", function() {
        const doc = $(this).data().document;
        $('#modal_destroy_document_name').text(doc.name);
        resource = deleteRoute.replace('%document_id%', doc.id)
        $('#documentDeleteModalSubmitButton').data('resource', resource);
        $('#documentDeleteModal').modal('show');

    });

    $("#documentModalSubmitButton").on('click', function(e) {
        e.preventDefault;

        parameters = {};
        url = $(this).data('resource');
        method = $(this).data('method');
        parameters['name'] = $('#name').val();
        parameters['id'] = $('#id').val();
        parameters['type_id'] = $('#type_id').val();
        parameters['values'] = [];


        index = 0;
        while ($("#key" + index).length) {

            obj = {}
            obj[$("#key" + index).val()] = $("#value" + index).val();
            parameters['values'].push({[$("#key" + index).val()] : $("#value" + index).val()});
            index++;
        }

        status = save(parameters, url, method)
        $('.modal-store-body').hide();
        if ( parseInt(status) === 200)
        {
            $('.modal-store-success').show();
        }
        else {
            $('.modal-store-fail').show();
        }

        setTimeout(function(){
            window.location.reload();
        }, 1000);
    });

    $("#documentDeleteModalSubmitButton").on('click', function(e) {
        e.preventDefault;

        url = $(this).data('resource');

        status = save([], url, 'DELETE')
        $('.modal-delete-body').hide();
        if ( parseInt(status) === 200)
        {
            $('.modal-delete-success').show();
        }
        else {
            $('.modal-delete-fail').show();
        }

        setTimeout(function(){
            window.location.reload();
        }, 1000);
    })

        function save(parameters, url, method) {
            code = 0;
            jQuery.ajax({
            url: url,
            method: method,
            async: false,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(parameters),
            success: function(response) {
                code = 200;
            },
            error: function(xhr, status, error) {
                code = 500;
            }
        });
        return code;

    }
  </script>

</div>
@endsection
