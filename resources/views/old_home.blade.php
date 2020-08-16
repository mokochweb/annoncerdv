@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   <div class="posts">
                       @if (!empty($posts))
                           @foreach($posts as $post)

                           <div class="row">
                               <div class="col-md-3" >
                                   <div class="bg-secondary" style="
                                           background: url({{ asset($post->user->avatar) }});
                                           border-radius: 150px;
                                           height: 200px;
                                           width: 200px">
                                   </div>
                               </div>
                               <div class="col-md-8" style="padding-left: 20px ; margin-top: 10px;">
                                   <p> Titre: {{ $post->titre }}</p>
                                   <p> Qté : {{ ( $post->quantite2 - $post->qte )}}</p>
                                   <p>Heure du rdv: {{ $post->Hbeginrdv . ' à  '. $post->Hendrdv }}</p>
                                   <p>Adresse: {{ $post->adresse }}</p>
                               </div>
                           </div>
                               <hr>
                           @endforeach
                       @else
                           <a href="{{ route('posts.create') }}">New posts</a>
                       @endif

                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
