@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Редактировать заявка') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{route('complaints.update', $complaint)}}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="theme" class="col-md-4 col-form-label text-md-right">{{ __('Тема') }}</label>

                                <div class="col-md-6">
                                    <input id="theme" type="text" class="form-control @error('theme') is-invalid @enderror" name="theme" value="{{ $complaint->theme }}" required autocomplete="theme" autofocus>

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
                                    <textarea rows="10" id="message" class="form-control @error('message') is-invalid @enderror" name="message" required autocomplete="message">{{ $complaint->message }}</textarea>

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
                                        {{ __('Сохранить') }}
                                    </button>
                                    <a href="{{route('complaints.show', $complaint)}}" class="btn btn-primary">
                                        {{ __('Отменить') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
