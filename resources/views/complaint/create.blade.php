@extends('layouts.app')

@section('page-navbar')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('complaints.index') }}">{{ __('Заявки') }}</a>
    </li>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Создать заявка') }}</div>

                    <div class="card-body">
                        @if(Auth::user()->isCreateComplaintInDay())
                            <div class="alert alert-warning" role="alert">
                                <h4 class="alert-heading">{{__('Пожалуйста, ждите!')}}</h4>
                                <p>{{__('Вы не можете оставлять заявку, чаще раза в сутки.')}}</p>
                                <hr>
                                <p class="mb-0">{{__('Извините за неудобства!')}}</p>
                            </div>
                        @else
                            <form method="POST" action="{{route('complaints.store')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="theme" class="col-md-4 col-form-label text-md-right">{{ __('Тема') }}</label>

                                <div class="col-md-6">
                                    <input id="theme" type="text" class="form-control @error('theme') is-invalid @enderror" name="theme" value="{{ old('theme') }}" required autocomplete="theme" autofocus>

                                    @error('theme')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="message" class="col-md-4 col-form-label text-md-right">{{ __('Сообщения') }}</label>

                                <div class="col-md-6">
                                    <textarea rows="10" id="message" class="form-control @error('message') is-invalid @enderror" name="message" required autocomplete="message">{{ old('message') }}</textarea>

                                    @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Прикрепит файл') }}</label>

                                <div class="col-md-6">
                                    <input id="file" type="file" class="@error('file') is-invalid @enderror" name="file">

                                    @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Отправить') }}
                                    </button>
                                    <a href="{{route('complaints.index')}}" class="btn btn-primary">
                                        {{ __('Отменить') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
