@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Page') }}</div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($pages as $page)
                                <li class="list-group-item">
                                    <a href="{{route('getPage',$page->id)}}">{{$page->title}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
