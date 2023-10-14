@props(['category', 'slug' => '', 'first' => null, 'mobile' => false])

@php
    //$new_slug .= '/' . $slug . '/' . $child_category->slug;
    $slug = $slug . '/' . $category->slug;
    if (!$mobile) {
        $class = $first == true ? 'header__navigation-menu-link' : 'header__navigation-drop-menu-link';
    } else {
        $class = $first == true ? 'header__mobile-menu-item' : 'header__mobile-dropdown-menu-link';
        $firstaTagClass = $first == true ? 'header__mobile-menu-item-link' : '';
    }

@endphp


<li class="{{ $class }}">
    <a class="{{ $firstaTagClass ?? '' }}" href="{{ $slug }}">{{ $category->name }}
        @if (count($category->children) > 0 && $first == true)
            <span class="drop-icon">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.33332 5.66667L7.99999 10.3333L12.6667 5.66667" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
        @endif
    </a>

    @if (count($category->children) > 0)
        <ul class="{{ $mobile == false ? 'header__navigation-drop-menu' : 'header__mobile-dropdown-menu' }}">
            @foreach ($category->children as $child)
                <x-front.header-menu :category="$child" :slug="$slug" :mobile="$mobile" />
            @endforeach
        </ul>
    @endif
</li>
