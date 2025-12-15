<div class="modal fade" id="{{ $city->id }}" aria-labelledby="modalLabel{{ $city->id }}">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel{{ $city->id }}">{{ $city->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('/storage/' . $city->coat_of_arms_image) }}" 
                             alt="Герб {{ $city->name }}"
                             style="max-height: 250px;">
                        <p class="mt-2 text-dark"><small>Герб города</small></p>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="{{ asset('/storage/' . $city->city_image) }}" 
                             class="img-fluid rounded-0 h-100 w-100 object-fit-cover" 
                             alt="{{ $city->name }}"
                             style="max-height: 250px;">
                        <p class="mt-2 text-dark"><small>Фотография города</small></p>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="mb-0">{{ $city->modal_text }}</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ $city->wiki_url }}" 
                       target="_blank" 
                       class="btn btn-primary">
                    Wikipedia
                    </a>
                    <button type="button" 
                            class="btn btn-outline-info rounded-0" 
                            data-bs-toggle="popover" 
                            data-bs-trigger="hover"
                            data-bs-placement="top"
                            data-bs-title="Интересный факт"
                            data-bs-content="{{ $city->interesting_fact }}">
                        Интересный факт
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>