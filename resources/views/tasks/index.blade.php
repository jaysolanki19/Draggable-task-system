@extends('tasks.layout')
@section('title')
    {{ 'Task Listing' }}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 class="text-center">Task Listing</h2>
        </div>
        @include('include.alert_message')
        <div class="pull-right d-flex justify-content-end">
            <a class="btn btn-success mb-2" href="{{ route('tasks.create') }}"> Create New Task</a>
        </div>
    </div>
</div>

<div class="task_box">
    <div class="column" id="High">
        <h3 class="text-center">High</h3>
        @foreach($high_priority_tasks as $task)
            <a href="{{route('tasks.show',['id'=>$task->id])}}" class="list-group-item" data-id="{{ $task->id }}" draggable="true">
               <h5 class="text-center">{{ $task->name }}</h5>
                {{-- <div class="form-check form-switch">
                    <input class="form-check-input toggle-switch" data-toggle="tooltip" data-placement="top" title="{{ $task->completed == 1 ? 'Mark as in complete' : 'Mark as complate' }}" type="checkbox" role="switch" data-id="{{ $task->id }}" id="flexSwitchCheckChecked" {{ $task->completed == 1 ? 'checked' : '' }}>
                </div> --}}
            </a>
        @endforeach
    </div>
    <div class="column" id="Medium">
        <h3 class="text-center">Medium</h3>
        @foreach($medium_priority_tasks as $task)
            <a href="{{route('tasks.show',['id'=>$task->id])}}" class="list-group-item" data-id="{{ $task->id }}" draggable="true">
                <h5 class="text-center">{{ $task->name }}</h5>
                {{-- <div class="form-check form-switch">
                    <input class="form-check-input toggle-switch" type="checkbox" role="switch" data-id="{{ $task->id }}" data-toggle="tooltip" data-placement="top" title="Tooltip on top" id="flexSwitchCheckChecked" {{ $task->completed == 1 ? 'checked' : '' }}>
                </div> --}}
            </a>
        @endforeach
    </div>
    <div class="column" id="Low">
        <h3 class="text-center">Low</h3>
        @foreach($low_priority_tasks as $task)
        <a href="{{route('tasks.show',['id'=>$task->id])}}" class="list-group-item" data-id="{{ $task->id }}" draggable="true">
            <h5 class="text-center">{{ $task->name }}</h5>
            {{-- <div class="form-check form-switch">
                <input class="form-check-input toggle-switch" type="checkbox" role="switch" data-id="{{ $task->id }}" id="flexSwitchCheckChecked" {{ $task->completed == 1 ? 'checked' : '' }}>
            </div> --}}
        </a>
        @endforeach
    </div>
</div>

@endsection

@section('scripts')
<script src="{{asset('js/sortable.min.js')}}"></script>
<script src="{{asset('js/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
    $('.column').sortable({
        cancel: 'h1',
        connectWith: '.column',
        ghostClass: "blue-background-class",
        update: function(event, ui) {
            var id = ui.item.attr('data-id');
            var priority = ui.item.parent().attr('id');
            $.ajax({
                url: "{{ route('update.tasks.priority') }}",
                data: { "id": id, "priority": priority, "_token": "{{ csrf_token() }}" },
                type: "POST",
                success: function(data) {
                }
            });
        }
    });

    $(".delete-task-btn").on("click", function() {
        var taskId = $(this).attr("data-id");
        swal({
            title: `Are you sure you want to delete this record?`,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: "{{ route('tasks.delete') }}",
                    data: { "id": taskId, "_token": "{{ csrf_token() }}" },
                    type: 'post',
                    success: function(result) {
                        $('[task-id="' + taskId + '"]').remove();
                    }
                });
            }
        });
    });

    $('.toggle-switch').change(function() {
        var status = $(this).prop('checked') == true ? 1 : 0; 
        var task_id = $(this).data('id'); 
         
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('tasks.update.status') }}",
            data: {'status': status, 'task_id': task_id,"_token":"{{ csrf_token() }}"},
            success: function(data){
            }
        });
    });
</script>
@endsection
