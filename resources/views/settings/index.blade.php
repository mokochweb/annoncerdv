@extends('layouts.app')

@section('content')
    <div class="row  justify-content-center">
        <div class="col-md-12">
            <h4 class="text-danger" style="text-align: center; font-size: 40px">{{ __('Paramètres') }}</h4>
        </div>

        <div class="col-md-8 offset-2">
            <form action="{{ route('settings.update') }}" method="post">
                @csrf

            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input @error('receive_new_post_email') is-invalid @enderror" name="receive_new_post_email" id="receive_new_post_email" {{ \Auth::user()->settings->receive_new_post_email == 'yes' ? 'checked' : '' }}>
                <label class="custom-control-label" for="receive_new_post_email">Envoyer notification par mail</label>
                @error('receive_new_post_email')
                    <span role="alert" class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>                

            <div class="form-group mt-3">
                <button class="btn btn-success btn-md" type="submit" style="background-color:gold; border-color:gold;">Envoyer</button>
            </div>
        </div>
    </div>
@endsection