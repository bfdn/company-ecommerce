<div class="form-check">
    {{-- @php
        if (empty($id)) {
            $id = uniqid('input-');
        }
    @endphp --}}



    <input type="radio" id="{{ $id ?? '' }}" name="{{ $name ?? '' }}"
        class="form-check-input {{ $attributes->get('class') }}" value="{{ $defaultValue ?? '' }}"
        @checked(old($name, $defaultValue ?? '')) {{ isset($isDisabled) && $isDisabled ? 'disabled' : '' }}>

    @isset($label)
        <label for="{{ $id ?? '' }}" class="form-check-label">{{ $label }}</label>
    @endisset

</div>
