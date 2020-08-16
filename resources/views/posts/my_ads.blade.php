@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-8">
                <h4 class="text-danger py-3" style="font-size: 40px">Mon compte </h4>
                <nav class="nav nav-tabs nav-justified">
                    <a href="{{ route('profile') }}" class="nav-item nav-link ">Mon profile</a>
                    <a href="{{ url('posts/my_ads') }}" class="nav-item nav-link active">Mes annonces</a>
                    <a href="#" class="nav-item nav-link ">S'abonner</a>
                    <a href="{{ route('messages.index') }}" class="nav-item nav-link">Ma messagerie</a>
                </nav>
                <div class="form-group" style="margin-top:50px;">
                    <a href="{{ route('posts.create') }}" class="alert alert-warning form-control"
                       style="text-decoration:none;background-color: rgb(255, 234, 64);color: white;padding-top: 20px;padding-bottom: 50px;font-size: 22px;padding-left: 30px;">Poster une annonce</a>
                </div>
                <div class="form-group">
                    <a href="{{ url('posts') }}" class="alert alert-info form-control" style="text-decoration:none;background-color: silver;color: white;padding-bottom: 50px;padding-top: 20px;font-size: 22px;padding-left: 30px;">
                        gérer mes annonces
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
