{{-- @dd($attributes->merge(['class' => 'form-select'])) --}}
{{-- @dd($attributes->class(['form-select'])) --}}
{{-- @dd($attributes->get('class')) --}}


<div class="form-group">
    @isset($label)
        <label for="{{ $id ?? '' }}" class="form-label">{{ $label }}</label>
    @endisset

    <select class="form-select {{ $attributes->get('class') }}" id="{{ $id ?? '' }}" name="{{ $name ?? '' }}"
        {{ isset($isDisabled) && $isDisabled ? 'disabled' : '' }}>
        <option value="{{ null }}">Seçiniz</option>
        @isset($options)
            @foreach ($options as $option)
                <option value="{{ $option->id }}" @selected(old($name) == $option->id)>{{ $option->name }}</option>
            @endforeach
        @endisset
    </select>
</div>
