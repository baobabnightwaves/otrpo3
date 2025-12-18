<div class="col-12 col-lg-6 col-xl-4 col-xxl-3">
    <div class="card h-100 shadow-sm custom-card">
        <div class="position-relative">
            <a href="{{ route('cities.show', $city) }}"
                title="Подробнее"> 
                <img src="{{ asset('/storage/' . $city->coat_of_arms_image) }}" 
                    class="card-img-top p-1" 
                    alt="Герб {{ $city->name }}"
                    style="height: 300px; object-fit: contain;">
            </a>
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
                <form action="{{ route('cities.destroy', $city) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Удалить город {{ $city->name }}?')"> 
                        Удалить
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>