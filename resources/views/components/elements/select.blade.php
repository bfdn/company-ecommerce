{{-- @dd($attributes->merge(['class' => 'form-select'])) --}}
{{-- @dd($attributes->class(['form-select'])) --}}
{{-- @dd($attributes->get('class')) --}}

{{-- @dd($attributes) --}}
@props(['label' => '', 'id' => '', 'options' => [], 'status' => [], 'defaultValue' => '', 'name' => '', 'dataUrl' => ''])


<div class="form-group">
    @isset($label)
        <label for="{{ $id ?? '' }}" class="form-label fs-6">{{ $label }}</label>
    @endisset



    <select class="form-select {{ $attributes->get('class') }}" id="{{ $id ?? '' }}" data-url="{{ $dataUrl }}"
        name="{{ $name ?? '' }}" {{ $attributes->get('multiple') }}
        {{ isset($isDisabled) && $isDisabled ? 'disabled' : '' }}>
        <option value="">Seçiniz</option>
        @isset($options)
            @foreach ($options as $option)
                <option value="{{ $option->id }}"
                    @if (is_array($defaultValue)) @selected(old($name, in_array($option->id,$defaultValue)) == $option->id)
                    @else
                    @selected(old($name, $defaultValue) == $option->id) @endif>
                    {{ $option->name }}</option>
            @endforeach
        @endisset
        @isset($status)
            @foreach ($status as $status_item)
                <option value="{{ $status_item->value }}" @selected(old($name, $defaultValue) == $status_item->value)>{{ $status_item->title() }}
                </option>
            @endforeach
        @endisset
    </select>
</div>
