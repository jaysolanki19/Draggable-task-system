@extends('tasks.layout')
@section('title')
    {{ 'Show Task' }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2 class="text-center">Task</h2>
            </div>
            @include('include.alert_message')
            <div class="pull-right d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('tasks.index') }}"> Back</a>
            </div>
        </div>
    </div>
     
    <div class="row form-box">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <div class="form-group">
                <strong>Task name:</strong>
                {{ $task->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
            <div class="form-group">
                <strong>Task description:</strong>
                {{ $task->description ?? '-' }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
            <div class="form-group">
                <strong>Priority:</strong>
                {{ $task->priority == 'High' ? 'High' : ($task->priority == 'Medium' ? 'Medium' : 'Low') }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
            <div class="form-group">
                <strong>Created At:</strong>
                {{ date('d-m-Y', strtotime($task->created_at)); }}

            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
            <div class="form-group">
                <strong>Chnage status:</strong>
                <input data-id="{{$task->id}}" class="toggle-class toggle-switch" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Completed" data-off="InCompleted" {{ $task->completed == 1 ? 'checked' : '' }}>
            </div>
        </div>
        @if($task->image)
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-2">
            <div class="form-group">
                <strong>Image:</strong>
            </div>
            <img src="{{asset($task->image)}}" width="200px" height="200px" alt="No image">
        </div>
        @endif
        <div class="pull-right d-flex justify-content-center mt-3">
            <a class="btn btn-primary" href="{{ route('tasks.edit',['id' => $task->id]) }}">Edit</a>
        </div>
    </div>
@endsection

@section('scripts')
<script>
     $('.toggle-switch').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var task_id = $(this).data('id'); 
         
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('tasks.update.status') }}",
            data: {'status': status, 'task_id': task_id,"_token":"{{ csrf_token() }}"},
            success: function(data){
                toastr.options =
                {
                    "closeButton" : true,
                    "progressBar" : true
                }
                toastr.success("Status change successfully. ");
            }
        });
    });
</script>
@endsection