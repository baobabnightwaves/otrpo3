<div class="col-12 col-lg-6 col-xl-4 col-xxl-3">
    <div class="card h-100 shadow-sm custom-card">
        @if($city->trashed())
            <div class="position-absolute top-0 start-50 translate-middle-x mt-2">
                <span class="badge bg-danger py-2 px-3">
                    Удален
                </span>
            </div>
        @endif
        <div class="position-relative">
            <img src="{{ asset('/storage/' . $city->coat_of_arms_image) }}" 
                 class="card-img-top p-1" 
                 alt="Герб {{ $city->name }}"
                 style="height: 200px; object-fit: contain;">
            <span class="position-absolute top-0 start-0 bg-white border px-3 py-2 fs-6 fw-semibold">
                Герб
            </span>
        </div>
        <div class="card-body d-flex flex-column">
            <h3 class="card-title">{{ $city->name }}</h3>
            <p class="card-text flex-grow-1">
                {{ $city->card_text }}
            </p>
            <div class="d-grid gap-2 mt-3">
                <a href="{{ route('cities.show', $city) }}" class="btn btn-primary rounded-0"> 
                    Подробнее
                </a>
                @auth
                    <a href="{{ route('cities.edit', $city) }}" class="btn btn-warning rounded-0"> 
                        Редактировать
                    </a>
                    <form action="{{ route('cities.destroy', $city) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 rounded-0" onclick="return confirm('Удалить город {{ $city->name }}?')"> 
                            Удалить
                        </button>
                    </form>
                    @if(Auth::user()->is_admin)
                        @if($city->trashed())
                            <form action="{{ route('cities.restore', $city->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 rounded-0" 
                                        onclick="return confirm('Восстановить город {{ $city->name }}?')">
                                    Восстановить
                                </button>
                            </form>
                            <div class="alert alert-danger py-1 px-2 mb-3 rounded-0">
                                <small>
                                    Удален: {{ $city->deleted_at->format('d.m.Y H:i') }}
                                </small>
                            </div>
                        @endif
                        @php
                            $owner = \App\Models\User::find($city->user_id);
                        @endphp
                        @if($owner)
                            <p class="text-dark mb-0">
                                Владелец: {{ $owner->name }}
                            </p>
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>