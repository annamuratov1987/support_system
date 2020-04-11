@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-10 m-auto">
            <div class="card border-success mb-3">
                <div class="card-header bg-transparent border-success text-success">
                    {{$complaint->author->name}}
                    <span class="badge badge-light badge-secondary">{{$complaint->updated_at}}</span>
                    <ul class="nav float-right">
                        @if(!Auth::user()->isManager())
                            <li class="nav-item">
                            <a class="btn btn-light" href="{{route('complaints.edit', $complaint)}}">{{__('Редактировать')}}</a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <h5 class="card-title text-success">{{$complaint->theme}}</h5>
                    <p class="card-text">{{$complaint->message}}</p>
                    @if($complaint->file_path != null)
                        <small><a href="/storage/app/{{$complaint->file_path}}">{{__('Прикрепленный файл')}}</a></small>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
