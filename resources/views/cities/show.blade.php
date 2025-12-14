@extends('web')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm rounded-0">
                <div class="card-header bg-primary text-white rounded-0">
                    <h1 class="h3 mb-0">{{ $city->name }}</h1>
                </div>
                <div class="card-body text-dark" style="background: #f5e5b8;">
                    <div class="row mb-4">
                        <div class="col-md-6 text-center">
                            <div class="position-relative">
                                <img src="{{ asset('/storage/' . $city->coat_of_arms_image) }}" 
                                     class="img-fluid" 
                                     alt="Герб {{ $city->name }}"
                                     style="height: 300px;">
                                <span class="position-absolute top-0 start-0 bg-white border px-3 py-2 fs-6 fw-semibold">
                                    Герб
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <img src="{{ asset('/storage/' . $city->city_image) }}" 
                                 class="img-fluid" 
                                 alt="{{ $city->name }}"
                                 style="height: 300px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mb-3">{{ $city->modal_title }}</h3>
                            <p class="lead">{{ $city->modal_text }}</p>
                            
                            <div class="mt-4 rounded-0">
                                <h5>Интересный факт</h5>
                                <div class="alert alert-info rounded-0">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    {{ $city->interesting_fact }}
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('cities.index') }}" class="btn btn-light btn-outline-dark rounded-0">
                                    <i class="fas fa-arrow-left me-2"></i>Назад к списку
                                </a>
                                <a href="{{ $city->wiki_url }}" target="_blank" class="btn btn-primary rounded-0">
                                    <i class="fas fa-external-link-alt me-2"></i>Читать на Wikipedia
                                </a>
                                <a href="{{ route('cities.edit', $city) }}" class="btn btn-warning rounded-0">
                                            <i class="fas fa-edit me-1"></i>Редактировать
                                        </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-dark rounded-0" style="background: #e7d090ff">
                                <div class="card-body">
                                    <p><strong>Дата создания:</strong> {{ $city->created_at->format('d.m.Y H:i') }}</p>
                                    <p><strong>Последнее обновление:</strong> {{ $city->updated_at->format('d.m.Y H:i') }}</p>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection