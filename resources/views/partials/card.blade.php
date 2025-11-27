<div class="col-12 col-lg-6 col-xl-4 col-xxl-3 col-xxxl-2">
    <div class="card h-100 shadow-sm custom-card">
        <div class="position-relative">
            <img src="{{ asset($city->coat_of_arms_image) }}" class="card-img-top p-4">
            <span class="position-absolute top-0 start-0 bg-white border px-3 py-2 fs-6 fw-semibold label-badge">Герб</span>
        </div>
        <div class="card-body d-flex flex-column">
            <h3 class="card-title">{{ $city->name }}</h3>
            <p class="card-text flex-grow-1">
                {{ $city->card_text }}
            </p>
            <button class="btn btn-outline-primary mt-auto" data-bs-toggle="modal" data-bs-target="#{{ $city->modal_id }}">Подробнее</button>
        </div>
    </div>
</div>