@props(['item'])

<div class="cards-blog">
    <div class="cards-blog__img-wrapper">
        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" />
        <div class="date">
            <h3 class="font-body--xxl-500">{{ date('d', strtotime($item->created_at)) }}</h3>
            <span class="font-body--sm-500">{{ date('m', strtotime($item->created_at)) }}</span>
        </div>
    </div>
    <div class="cards-blog__info">
        <div class="cards-blog__info-tags d-flex">
            <div class="cards-blog__info-tags-item">
                <span>
                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.1583 11.6748L11.1833 17.6498C11.0285 17.8048 10.8447 17.9277 10.6424 18.0116C10.4401 18.0955 10.2232 18.1386 10.0042 18.1386C9.78513 18.1386 9.56825 18.0955 9.36592 18.0116C9.16359 17.9277 8.97978 17.8048 8.82499 17.6498L1.66666 10.4998V2.1665H9.99999L17.1583 9.32484C17.4687 9.63711 17.643 10.0595 17.643 10.4998C17.643 10.9401 17.4687 11.3626 17.1583 11.6748V11.6748Z"
                            stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M5.83331 6.33301H5.84165" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </span>
                {{ $item->category->name ?? '' }}
            </div>
            <div class="cards-blog__info-tags-item">
                <span>
                    <svg width="14" height="17" viewBox="0 0 14 17" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.99993 7.66667C8.84088 7.66667 10.3333 6.17428 10.3333 4.33333C10.3333 2.49238 8.84088 1 6.99993 1C5.15898 1 3.6666 2.49238 3.6666 4.33333C3.6666 6.17428 5.15898 7.66667 6.99993 7.66667Z"
                            stroke="currentColor" stroke-width="1.2" />
                        <path
                            d="M9.49995 10.1665H4.49995C2.19828 10.1665 0.137447 12.2915 1.65161 14.024C2.68161 15.2023 4.38495 15.9998 6.99995 15.9998C9.61495 15.9998 11.3174 15.2023 12.3474 14.024C13.8624 12.2907 11.8008 10.1665 9.49995 10.1665Z"
                            stroke="currentColor" stroke-width="1.2" />
                    </svg>
                </span>
                {{ $item->user->name??'' }}
            </div>

        </div>
        <a href="{{ route('front.blogDetail', ['article' => $item->slug]) }}"
            class="blog-title font-body--xl-500">{{ substr($item->name, 0, 20) }}</a>
        <a href="{{ route('front.blogDetail', ['article' => $item->slug]) }}">
            {{ __('front.read_more') }}
            <span>
                <svg width="17" height="15" viewBox="0 0 17 15" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 7.50049H1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M9.95001 1.47559L16 7.49959L9.95001 13.5246" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
        </a>
    </div>
</div>
