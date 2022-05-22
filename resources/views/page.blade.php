@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="p-3 mb-2 bg-secondary text-white">
                    <h1 class="">{{$page->title}}</h1>
                    <p><span class="text-info">page status is:</span> {{$page->status}}</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Page') }}</div>

                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <comments-component
                                :comments-count="{{ $page->comments_count }}"
                                :comments-pre="{{ $page->preComment }}"
                                :comments="{{ $page->comments }}"
                                :post-id="{{ $page->id }}"
                                :user-id="{{ auth()->user()->id }}">
                            </comments-component>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
