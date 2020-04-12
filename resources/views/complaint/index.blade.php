@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach($complaints as $complaint)
            <div class="col-9 m-auto">
                <div class="card border-success mb-3">
                    <div class="card-header bg-transparent text-success">
                        @switch($complaint->status)
                            @case('created')
                            <span class="badge badge-danger">!</span>
                            @break
                            @case('viewed')
                            <span class="badge badge-warning">!</span>
                            @break
                            @case('accept')
                            <span class="badge badge-primary">&#9850;</span>
                            @break
                            @case('answered')
                            <span class="badge badge-success">&#10004;</span>
                            @break
                            @case('unviewed')
                            <span class="badge badge-danger">&#9993;</span>
                            @break
                            @default
                            <span class="badge badge-secondary">&#10008;</span>
                        @endswitch
                        {{$complaint->author->name}}
                        <span class="badge badge-light badge-secondary">{{$complaint->updated_at}}</span>
                        <ul class="nav float-right">
                            <li class="nav-item">
                                <a class="btn btn-light" href="{{route('complaints.show', $complaint)}}">{{__('Подробно')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><a class="text-success" href="{{route('complaints.show', $complaint)}}">{{$complaint->theme}}</a></h5>
                        <p class="card-text">{{$complaint->message}}</p>
                        @if($complaint->file_path != null)
                            <small><a href="/storage/app/{{$complaint->file_path}}">{{__('Прикрепленный файл')}}</a></small>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
