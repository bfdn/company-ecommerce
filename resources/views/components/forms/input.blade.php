{{-- <div class="col-md-6 col-12"> --}}
{{-- @isset($parentElement)
    <{{ $parentElement }} class="{{ isset($parentClass) ? $parentClass : '' }}">
    @endisset --}}

<div class="form-group">
    @php
        if (empty($id)) {
            $id = uniqid('input-');
        }
    @endphp

    @isset($label)
        <label for="{{ $id ?? '' }}" class="form-label">{{ $label }}</label>
    @endisset

    <input type="{{ $type ?? 'text' }}" id="{{ $id ?? '' }}"
        class="{{ $type != 'submit' && $type != 'button' ? 'form-control' : '' }} {{ $attributes->get('class') }}"
        placeholder="{{ $placeHolder ?? '' }}" name="{{ $name ?? '' }}" value="{{ $defaultValue ?? '' }}"
        {{ isset($isDisabled) && $isDisabled ? 'disabled' : '' }}>
</div>


{{-- @isset($parentElement)
    </{{ $parentElement }}>
@endisset --}}

{{-- </div> --}}
