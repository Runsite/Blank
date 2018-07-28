@extends('layouts.middle.search')

@section('search-results')

    @if(! count($searchResults))
        <div class="alert alert-info">
            {{ t('Not results found') }}
        </div>
    @endif

    <ul>
        @foreach($searchResults as $searchResult)
        <li>
            <a href="{{ lPath($searchResult->node->path->name) }}">
                {{ $searchResult->name }}
            </a>
        </li>
        @endforeach
    </ul>

@endsection
