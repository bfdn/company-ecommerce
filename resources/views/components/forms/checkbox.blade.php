<div class="form-check">
    <div class="checkbox">
        @php
            if (empty($id)) {
                $id = uniqid('input-');
            }
        @endphp



        <input type="checkbox" id="{{ $id ?? '' }}" name="{{ $name ?? '' }}"
            class="form-check-input {{ $attributes->get('class') }}" value="{{ $defaultValue ?? '' }}"
            @checked(old($name, $defaultValue ?? '')) {{ isset($isDisabled) && $isDisabled ? 'disabled' : '' }}>

        @isset($label)
            <label for="{{ $id ?? '' }}" class="form-label">{{ $label }}</label>
        @endisset

    </div>
</div>
