@extends('web')
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card text-dark">
                <div class="card-header bg-primary text-white">
                    Добавить комментарий к городу: {{ $city->name }}
                </div>
                <div class="card-body">
                    <a href="{{ route('comments.index', $city) }}" class="btn btn-outline-dark mb-3">
                        Назад к комментариям
                    </a>

                    <form method="POST" action="{{ route('comments.store', $city) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="content" class="form-label fw-bold">Ваш комментарий:</label>
                            <textarea 
                                id="content" 
                                name="content" 
                                rows="5"
                                class="form-control text-dark @error('content') is-invalid @enderror"
                                placeholder="Напишите ваш комментарий..."
                                required
                            >{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Опубликовать комментарий
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
