@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ url('css/styleMessagerie.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-8">
                <h4 class="text-danger py-3" style="font-size: 40px">Mon compte </h4>
                <nav class="nav nav-tabs nav-justified">
                    <a href="{{ route('profile') }}" class="nav-item nav-link ">Mon profile</a>
                    <a href="{{ url('posts/my_ads') }}" class="nav-item nav-link ">Mes annonces</a>
                    <a href="#" class="nav-item nav-link ">S'abonner</a>
                    <a href="{{ route('messages.index') }}" class="nav-item nav-link active">Ma messagerie </a>
                </nav>
            </div>
            <div class="col-md-12 pt-5">
                <messagerie-component
                    :datas="{{ $from }}"
                    :user="{{ \Illuminate\Support\Facades\Auth::id() }}"
                ></messagerie-component>
            </div>
        </div>
    </div>
@endsection
