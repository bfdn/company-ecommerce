<button type="{{ $type ?? 'button' }}" class="{{ $class ?? '' }}" id="{{ $id ?? '' }}"
    {{ isset($isDisabled) && $isDisabled ? 'disabled' : '' }}
    @isset($dataUrl) data-url="{{ $dataUrl }}" @endisset>{{ $buttonText ?? '' }}</button>
