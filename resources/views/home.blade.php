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
        <div class="col-2">
            <h1>Filters</h1>
            <div class="row justify-content-center border">
                <div class="col-8">
                    <form action="{{ route('articles.category.search') }}" method="get">
                        <input type="text" name="category">
                        <button class="btn btn-info font-weight-bold">Search</button>
                    </form>
                    <a href="{{ route('home') }}" class="btn btn-info font-weight-bold d-block my-2">All</a>
                    @foreach ($sections as $section)
                    <a href="{{ route('articles.section', $section->slug) }}" class="btn btn-info font-weight-bold d-block my-2">{{ $section->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-10">
            <div class="container my-3">
                <div class="row">
                    @foreach ($articles as $article)
                    <article class="col-12 col-md-3 my-3">
                        <div class="card bg-dark text-white">
                            <picture>
                                <img class="card-img-top" src="https://picsum.photos/300/300" alt="Card image cap">
                            </picture>
                            <div class="card-body">
                            <h3 class="card-title">{{ $article->title }}...</h3>
                            <h5 class="card-text">{{ $article->section->name }}</h5>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


    

@endsection
