@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1>
               The Guardian Blog
            </h1>
        </div>
    </div>
</div>


<div class="container-fluid my-5">
    <div class="row">
        <div class="col-3">
            <h1>Filters</h1>
            <div class="row justify-content-center border">
                <div class="col-8">
                    <a href="{{ route('home') }}" class="btn btn-info font-weight-bold d-block my-2">All</a>
                    <a href="{{ route('articles.category', ['category' => 'politics']) }}" class="btn btn-info font-weight-bold d-block my-2">Politics</a>
                    <a href="{{ route('articles.category', ['category' => 'sport']) }}" class="btn btn-info font-weight-bold d-block my-2">Sport</a>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="container my-3">
                <div class="row">
                    @foreach ($articles as $article)
                    <div class="col-12 col-md-3 my-3">
                        <div class="card bg-dark text-white">
                            <img class="card-img-top" src="https://picsum.photos/300/300" alt="Card image cap">
                            <div class="card-body">
                            <h3 class="card-title">{{ $article->webTitle }}</h3>
                            <h5 class="card-text">{{ $article->sectionName }}</h5>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


    

@endsection
