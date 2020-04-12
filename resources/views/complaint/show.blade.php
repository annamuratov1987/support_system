@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-10 m-auto">
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
                        @if(!Auth::user()->isManager())
                        <li class="nav-item">
                            <a class="btn btn-light" href="{{route('complaints.edit', $complaint)}}">{{__('Редактировать')}}</a>
                        </li>
                        <li class="nav-item ml-2">
                            <a class="btn btn-light" href="{{route('complaints.close', $complaint)}}">{{__('Закрыть')}}</a>
                        </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-light" href="{{route('complaints.accept', $complaint)}}">{{__('Принять')}}</a>
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
                <div class="card-footer bg-transparent">
                    <div class="list-group-flush">
                        @foreach($answers as $answer)
                            <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <span class="text-success">{{$answer->author->name}}</span>
                                <small class="float-right">
                                    <span class="badge badge-light badge-secondary">{{$answer->created_at}}</span>
                                </small>
                            </div>
                            <p class="mb-1">{{$answer->text}}</p>
                            @if($answer->file_path != null)
                                <small><a href="/storage/app/{{$answer->file_path}}">{{__('Прикрепленный файл')}}</a></small>
                            @endif
                        </div>
                        @endforeach
                        @if($complaint->status != 'closed')
                        <div class="list-group-item">
                            <form method="POST" action="{{route('complaints.answer', $complaint)}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <textarea id="text" class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text">{{ old('text') }}</textarea>

                                        @error('text')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <input id="file" type="file" class="@error('file') is-invalid @enderror" name="file">

                                        @error('file')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Ответить') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
