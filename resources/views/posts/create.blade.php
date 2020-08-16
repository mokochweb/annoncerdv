@extends('layouts.app')

@section('content')

    <div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        <div class="row justify-content-center">

            @if (isset($post))
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Modifier l'annonce</div>


                        <div class="card-body">
                            <form method="POST" action="{{ route('posts.update1', $id) }}">
                                @csrf
                                <div class="form-group row">
                                    <label for="title" class="col-md-3 col-form-label text-md-right">Titre</label>

                                    <div class="col-md-9">


                                        <input id="title" type="text"
                                               class="form-control @error('title') is-invalid @enderror" name="title"
                                               value="{{ $post->titre ?? old('title') }}" required autocomplete="email" required>

                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="qte" class="col-md-3 col-form-label text-md-right">Quantité
                                        entre</label>
                                    <div class="col-md-9 row">
                                        <div class="col-md-6">
                                            <input type="qte" min="1" max="100"
                                                   class="form-control  @error('qte') is-invalid @enderror"
                                                   value="{{ $post->qte ?? old('qte') }}" name="qte" required
                                                   autocomplete="qte">
                                            @error('qte')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <input type="number" min="1" max="100"
                                                   class="form-control  @error('quantite2') is-invalid @enderror"
                                                   value="{{ $post->quantite2 ?? old('quantite2') }}" name="quantite2"
                                                   required autocomplete="quantite2" required>

                                            @error('quantite2')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label for="password-confirm" class="col-md-3 col-form-label text-md-right">Date de
                                        rdv entre</label>
                                    <div class="col-md-4">
                                        <input id="date_b" type="date"
                                               class="form-control @error('date_b') is-invalid @enderror "
                                               value="{{ $post->daterdvbegin ?? old('date_b') }}" name="date_b"
                                               autocomplete="Date">
                                        @error('date_b')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input id="date_e" type="date"
                                               class="form-control @error('date_e') is-invalid @enderror "
                                               value="{{  $post->daterdvend ?? old('date_e') }}" name="date_e"
                                               autocomplete="Date">
                                        @error('date_e')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-3 col-form-label text-md-right">Heure
                                        rdv entre</label>
                                    <div class="col-md-4">

                                        <input id="time_e" type="time"
                                               class="form-control @error('time_b') is-invalid @enderror "
                                               value="{{ $post->Hbeginrdv ?? old('time_b') }}" name="time_b"
                                               autocomplete="Date">
                                        @error('time_b')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">

                                        <input id="time_e" type="time"
                                               class="form-control @error('time_e') is-invalid @enderror "
                                               value="{{ $post->Hendrdv ?? old('time_e') }}" name="time_e"
                                               autocomplete="Date">
                                        @error('time_e')
                                        <span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm"
                                           class="col-md-3 col-form-label text-md-right">{{ __('Adress') }}</label>
                                    <div class="col-md-9">
                                        <input id="adresse_ajax" type="text"
                                               class="form-control @error('adressajax') is-invalid @enderror"
                                               value="{{ $post->adresse  ?? old('adressajax') }}" name="adressajax"
                                               required autocomplete="Date" list="adressajaxs"
                                               onkeypress="ajaxadress(this)" required>
                                        <datalist id="adressajaxs"></datalist>
                                        @error('adressajax')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-3">
                                        <button type="submit" class="btn btn-primary"
                                                style="background-color:gold; border-color:gold;">
                                            Modifier l'annonce
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">
                            <h1>Formulaire annonce</h1>
                            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data"
                                  id="post_New">
                                @csrf

                                <div class="form-group row">
                                    <label for="title" class="col-md-3 col-form-label text-md-right">Titre</label>

                                    <div class="col-md-9">


                                        <input id="title" type="text"
                                               class="form-control @error('title') is-invalid @enderror" name="title"
                                               value="{{ old('title') }}" required autocomplete="email">

                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="qte" class="col-md-3 col-form-label text-md-right">Quantité
                                        entre</label>
                                    <div class="col-md-9 row">
                                        <div class="col-md-6">
                                            <input type="number" min="1" max="100"
                                                   class="form-control  @error('quantite1') is-invalid @enderror"
                                                   value="{{ old('quantite1') }}" name="quantite1" required
                                                   autocomplete="quantite1">
                                            @error('qte')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <input type="number" min="1" max="100"
                                                   class="form-control  @error('quantite2') is-invalid @enderror"
                                                   value="{{ old('quantite2') }}" name="quantite2" required
                                                   autocomplete="quantite2">

                                            @error('quantite2')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row">

                                    <label for="date_b" class="col-md-3 col-form-label text-md-right">Date rdv
                                        entre</label>
                                    <div class="col-md-4">
                                        <input id="date_b" type="date"
                                               class="form-control @error('date_b') is-invalid @enderror "
                                               value="{{ old('date_b') }}" name="date_b"  autocomplete="Date">
                                        @error('date_b')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <input id="date_e" type="date"
                                               class="form-control @error('date_e') is-invalid @enderror "
                                               value="{{ old('date_e') }}" name="date_e"  autocomplete="Date">
                                        @error('date_e')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="Hbeginrdv" class="col-md-3 col-form-label text-md-right">Heure rdv
                                        entre</label>
                                    <div class="col-md-4">

                                        <input id="time_e" type="time"
                                               class="form-control @error('time_b') is-invalid @enderror "
                                               value="{{ old('time_b') }}" name="time_b"  autocomplete="Date">
                                        @error('time_b')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">

                                        <input id="time_e" type="time"
                                               class="form-control @error('time_e') is-invalid @enderror "
                                               value="{{ old('time_e') }}" name="time_e"  autocomplete="Date">
                                        @error('time_e')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="adresse" class="col-md-3 col-form-label text-md-right">Adresse
                                        rdv</label>
                                    <div class="col-md-9">
                                        <input id="adresse_ajax" type="text"
                                               class="form-control @error('adressajax') is-invalid @enderror"
                                               value="{{ old('adressajax') }}" name="adressajax" required
                                               autocomplete="Date" list="adressajaxs" onkeypress="ajaxadress(this)">
                                        <datalist id="adressajaxs"></datalist>
                                        @error('adressajax')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-3">
                                        <button type="submit" class="btn btn-primary"
                                                style="background-color:gold; border-color:gold;">
                                            Poster
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @php
                $posts = DB::select('select * from posts ', [1]);
            @endphp

        </div>
    </div>
    <script>
        function ajaxadress(element) {
            // Get the <datalist> and <input> elements.
            var dataList = document.getElementById('adressajaxs');
            var input = document.getElementById('adresse_ajax');

// Create a new XMLHttpRequest.
            var request = new XMLHttpRequest();

// Handle state changes for the request.
            request.onreadystatechange = function (response) {
                if (request.readyState === 4) {
                    if (request.status === 200) {
                        dataList.innerHTML = '';
                        JSON.parse(request.response).data.forEach(function (item) {
                            var option = document.createElement('option');
                            option.innerHTML = item.adress;
                            option.value = item.adress;
                            // option.value = item.id ;
                            dataList.appendChild(option);
                        });
                        input.placeholder = "Adress géo";
                    } else {

                        input.placeholder = "Couldn't load adress options :(";
                    }
                }
            };

            input.placeholder = "Loading options...";
            request.open('GET', location.origin + '/adress/' + element.value, true);
            request.send();

        }


    </script>
@endsection
