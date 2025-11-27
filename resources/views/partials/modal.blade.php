<div class="modal fade" id="{{ $city->modal_id }}" data-index="1" aria-labelledby="{{ $city->modal_id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $city->modal_id }}Label">{{ $city->modal_title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6 text-center">
                        <img src="{{ asset($city->coat_of_arms_image) }}" class="img-fluid">
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="{{ asset($city->city_image) }}" class="img-fluid">
                    </div>
                </div>
                <p>
                    {{ $city->modal_text }}
                </p>
                <a href="{{ $city->wiki_url }}" target="_blank" class="btn btn-primary">Источник</a>
                <br>
                <span tabindex="0" class="btn btn-light mt-2" style="color: black; cursor: pointer;" 
                    data-bs-toggle="popover" data-bs-trigger="hover" title="Интересный факт"
                    data-bs-content="{{ $city->interesting_fact }}">
                    Интересный факт
                </span>
            </div>
        </div>
    </div>
</div>