@props(['category', 'categoryFullName' => '', 'defaultValue' => '', 'name' => ''])

@php
    //$new_slug .= '/' . $slug . '/' . $child_category->slug;
    $categoryFullName = $categoryFullName . ' > ' . $category->name;
    if ($category->parent_id == null) {
        $categoryFullName = $category->name;
    }
    // $class = $first == true ? 'header__navigation-menu-link' : 'header__navigation-drop-menu-link';
@endphp

{{-- <option value="{{ $category->id }}" @selected(old($name, $defaultValue) == $category->id)>{!! $categoryFullName !!}</option> --}}
<option value="{{ $category->id }}"
    @if (is_array($defaultValue)) @selected(old($name, in_array($category->id,$defaultValue)) == $category->id)
    @else
    @selected(old($name, $defaultValue) == $category->id) @endif>
    {!! $categoryFullName !!}</option>


@if (count($category->children) > 0)
    @foreach ($category->children as $child)
        <x-elements.option :category="$child" :categoryFullName="$categoryFullName" :name="$name" :defaultValue="$defaultValue ?? ''" />
    @endforeach
@endif
