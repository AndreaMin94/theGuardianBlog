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


<div class="container my-3">
    <div class="row">
        @foreach ($articles as $article)
        <div class="col-12 col-md-3 my-3">
            <div class="card">
                <img class="card-img-top" src="https://picsum.photos/300/300" alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
    

@endsection
