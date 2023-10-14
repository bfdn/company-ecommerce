<div class="form-group">
    @php
        if (empty($id)) {
            $id = uniqid('input-');
        }
    @endphp

    @isset($label)
        <label for="{{ $id ?? '' }}" class="form-label fs-6">{{ $label }}</label>
    @endisset

    <input type="{{ $type ?? 'text' }}" id="{{ $id ?? '' }}"
        class="{{ $type != 'submit' && $type != 'button' ? 'form-control' : '' }} {{ $attributes->get('class') }}"
        {{ $attributes->get('multiple') }} placeholder="{{ $placeHolder ?? '' }}" name="{{ $name ?? '' }}"
        value="{{ old($name, $defaultValue ?? '') }}" {{ isset($isDisabled) && $isDisabled ? 'disabled' : '' }}>
</div>
