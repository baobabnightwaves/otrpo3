@csrf
@if(isset($city) && $city->id)
    @method('PUT')
@endif
<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">Название города</label>
            <input type="text" class="form-control text-dark rounded-0 @error('name') is-invalid @enderror" 
                   id="name" name="name" value="{{ old('name', $city->name ?? '') }}" 
                   required maxlength="255">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="coat_of_arms_image" class="form-label">
                Изображение герба
            </label>
            <input type="file" class="form-control text-dark rounded-0 rounded-0 @error('coat_of_arms_image') is-invalid @enderror" 
                   id="coat_of_arms_image" name="coat_of_arms_image" 
                   accept=".jpg,.jpeg,.png,.gif,.svg"
                   @if(!isset($city)) required @endif>
            @error('coat_of_arms_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if(isset($city) && $city->coat_of_arms_image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $city->coat_of_arms_image) }}" 
                         alt="Текущий герб" class="img-thumbnail" style="max-height: 150px;">
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-3">
            <label for="city_image" class="form-label">
                Изображение города
            </label>
            <input type="file" class="form-control text-dark rounded-0 @error('city_image') is-invalid @enderror" 
                   id="city_image" name="city_image" 
                   accept=".jpg,.jpeg,.png,.gif,.svg"
                   @if(!isset($city)) required @endif>
            @error('city_image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            @if(isset($city) && $city->city_image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $city->city_image) }}" 
                         alt="Текущее фото города" class="img-thumbnail" style="max-height: 150px;">
                </div>
            @endif
        </div>
    </div>
</div>
<div class="mb-3">
    <label for="card_text" class="form-label">Текст карточки</label>
    <textarea class="form-control text-dark rounded-0 @error('card_text') is-invalid @enderror" 
              id="card_text" name="card_text" rows="3" 
              required maxlength="500">{{ old('card_text', $city->card_text ?? '') }}</textarea>
    @error('card_text')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="modal_text" class="form-label">Текст модального окна</label>
    <textarea class="form-control text-dark rounded-0 @error('modal_text') is-invalid @enderror" 
              id="modal_text" name="modal_text" rows="5" 
              required>{{ old('modal_text', $city->modal_text ?? '') }}</textarea>
    @error('modal_text')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="wiki_url" class="form-label">Ссылка на Wikipedia</label>
    <input type="url" class="form-control text-dark rounded-0 @error('wiki_url') is-invalid @enderror" 
           id="wiki_url" name="wiki_url" value="{{ old('wiki_url', $city->wiki_url ?? '') }}" 
           required maxlength="500">
    @error('wiki_url')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label for="interesting_fact" class="form-label">Интересный факт</label>
    <textarea class="form-control text-dark rounded-0 @error('interesting_fact') is-invalid @enderror" 
              id="interesting_fact" name="interesting_fact" rows="3" 
              required maxlength="1000">{{ old('interesting_fact', $city->interesting_fact ?? '') }}</textarea>
    @error('interesting_fact')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
    <a href="{{ route('cities.index') }}" class="btn btn-secondary me-md-2 rounded-0">Отмена</a>
    <button type="submit" class="btn btn-primary rounded-0">
        @if(isset($city) && $city->id)
            Обновить город
        @else
            Создать город
        @endif
    </button>
</div>