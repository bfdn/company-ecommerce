@props(['formSwitch' => false, 'name' => '', 'label' => '', 'defaultValue' => '', 'isDisabled' => false, 'dataUrl' => '', 'rolePerm' => false, 'rolePermissions' => []])


<div class="form-check @if ($formSwitch === true) form-switch @endif">


    <div class="checkbox">
        @php
            if (empty($id)) {
                $id = uniqid('input-');
            }

        @endphp





        <input type="checkbox" id="{{ $id ?? '' }}" name="{{ $name ?? '' }}"
            class="form-check-input {{ $attributes->get('class') }}" value="{{ old($name, $defaultValue ?? '') }}"
            {{ $checked ?? '' }} {{-- @if (!isset($role_permissions)) {{ @checked(old($name, $defaultValue ?? '')) }} @endif --}}
        @if ($rolePerm) @if (in_array($defaultValue, $rolePermissions))
                checked @endif @else
            {{-- {{$defaultValue == 1 ? "checked":""}} --}} @checked(old($name, $defaultValue ?? '')) @endif
        @isset($dataUrl) data-url="{{ $dataUrl }}" @endisset
        {{ isset($isDisabled) && $isDisabled ? 'disabled' : '' }} />

        @isset($label)
            <label for="{{ $id ?? '' }}" class="form-label">{{ $label }}</label>
        @endisset

    </div>
</div>
