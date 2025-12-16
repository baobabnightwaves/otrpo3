<div class="col-12 col-lg-6 col-xl-4 col-xxl-3">
    <div class="card h-100 shadow-sm custom-card {{ $city->trashed() ? 'opacity-50' : '' }}">
        <div class="position-relative">
            @if (!$city->trashed())
                <a href="{{ route('cities.show', $city) }}">
            @endif
                <img src="{{ asset('/storage/' . $city->coat_of_arms_image) }}" 
                    class="card-img-top p-2" 
                    alt="Герб {{ $city->name }}"
                    style="height: 300px; object-fit: contain;">
            @if (!$city->trashed())
                </a>
            @endif
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
                @if (Gate::allows('modify-object', $city))
                    @if(!$city->trashed())
                        <form action="{{ route('cities.destroy', $city) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Удалить город {{ $city->name }}?')"> 
                                Удалить
                            </button>
                        </form>
                    @else
                        @if (Auth::check() && Auth::user()->is_admin)
                            <form action="{{ route('cities.purge', $city->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Безвозвратно удалить город {{ $city->name }}?')"> 
                                    Удалить безвозвратно
                                </button>
                            </form>
                        @endif
                    @endif
                @endif
                    @if($city->trashed() && Auth::check() && Auth::user()->is_admin)
                        <form action="{{ route('cities.restore', $city->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Восстановить город {{ $city->name }}?')"> 
                                Восстановить
                            </button>
                        </form>
                    @endif
                @php
                    $owner = \App\Models\User::find($city->user_id);
                @endphp
                @if($owner)
                    <p class="text-dark mb-0">
                        Владелец: {{ $owner->name }}
                    </p>
                    <p class="text-dark mb-0">
                        Почта: {{ $owner->email}}
                    </p>
                @else
                    <p class="text-dark mb-0">
                        Нет владельца
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>