@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">

                <h1>{{ $parentSection->name }} / {{ $fields->name }}</h1>
                @yield('search-results')
            </div>
            <div class="col-md-3">
                {{-- Search categories --}}
                
                <div class="list-group">
                    @foreach($searchCategories as $searchCategory)
                        <a href="{{ lPath($searchCategory->node->path->name) . '?term=' . request('term') }}" class="list-group-item">
                            {{ $searchCategory->name }}
                        </a>
                    @endforeach
                </div>
                
                {{-- / Search categories --}}
            </div>
        </div>
    </div>
@endsection
