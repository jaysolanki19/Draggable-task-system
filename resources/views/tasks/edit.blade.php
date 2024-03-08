@extends('tasks.layout')
@section('title')
    {{ 'Edit Task' }}
@endsection

@section('content')

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 class="text-center">Edit Task</h2>
        </div>
        <div class="pull-right d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ route('tasks.show',['id' => $task->id]) }}"> Back</a>
        </div>
    </div>
</div>
   
<form action="{{ route('tasks.update') }}" id="editTaskForm" class="form-box " method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="task_id" name="task_id" value="{{$task->id}}">
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name" value="{{$task->name}}">
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <input class="form-control" name="description" placeholder="Description" value="{{ $task->description }}">
                @error('description')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <strong>Priority:</strong>
            <div class="form-group">
                <select id="priority" class="form-control" name="priority">
                    <option value="high" {{ $task->priority === \App\Models\Task::PRIORITY_HIGH ? 'selected' : '' }}>High</option>
                    <option value="medium" {{ $task->priority === \App\Models\Task::PRIORITY_MEDIUM ? 'selected' : '' }}>Medium</option>
                    <option value="low" {{ $task->priority === \App\Models\Task::PRIORITY_LOW ? 'selected' : '' }}>Low</option>
                </select>
            </div>
            @error('priority')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Upload File:</strong>
                <div class="preview-zone hidden">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <div><b>Preview</b></div>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-danger btn-xs remove-preview">
                                    <i class="fa fa-times"></i> Reset image
                                </button>
                            </div>
                        </div>
                        <div class="box-body"></div>
                    </div>
                </div>
                <div class="dropzone-wrapper">
                    <div class="dropzone-desc">
                        <i class="glyphicon glyphicon-download-alt"></i>
                        <p>Choose an image file or drag it here.</p>
                    </div>
                    <input type="file" name="image" id="image" class="dropzone">
                </div>
                <label id="image-error" class="error" for="image"></label>
                @error('image')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        @if($task->image)
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <img src="{{asset($task->image)}}" class="mt-3" alt="No image" width="100px" height="100px">
            </div>
        </div>
        @endif
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endsection