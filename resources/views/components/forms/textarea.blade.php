<div class="form-group">
    @isset($label)
        <label for="{{ $id ?? '' }}" class="form-label">{{ $label }}</label>
    @endisset

    <textarea {{ $attributes->merge(['class' => 'form-control']) }} id="{{ $id ?? '' }}" rows="{{ $rows ?? '5' }}"
        cols="{{ $cols ?? '10' }}" name="{{ $name ?? '' }}" {{ isset($isDisabled) && $isDisabled ? 'disabled' : '' }}>{{ $defaultValue ?? '' }}</textarea>
    {{-- old($name) == $option->id --}}
</div>
