@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row  justify-content-center ">
            <div class="col-md-8">
                <h4 class="text-danger py-3" style="font-size: 40px">Mon compte </h4>
                <nav class="nav nav-tabs nav-justified">
                    <a href="{{ route('profile') }}" class="nav-item nav-link active">Mon profile</a>
                    <a href="{{ url('posts/my_ads') }}" class="nav-item nav-link">Mes annonces</a>
                    <a href="#" class="nav-item nav-link ">S'abonner</a>
                    <a href="{{ route('messages.index') }}" class="nav-item nav-link">Ma messagerie</a>
                </nav>
            </div>
            <form method="POST" action="{{ route('users.update', Auth::user()->id) }}" class="col-md-8 py-4"
                  enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="PUT">
                <h2>Vos identifiants</h2>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                           class="form-control @error('email') is-invalid @enderror">
                    @error('email')
                    <span role="alert" class="invalid-feedback">{{ $message }} 
                        <div class="notification">
                                    @if(\Helper::get_unread_message_count() > 0)
                                    <span class="badge badge-pill badge-warning unread_noti">{{\Helper::get_unread_message_count()}}</span>
                                    @endif
                        </div>
                    </span>
                    @enderror
                </div>
                <h2>Changer Mot de passe</h2>
                <div class="form-group show_hide_password">
                    <label>Ancien mot de passe</label>
                    <input type="password" name="old_password" id="old_password"
                           class="form-control @error('old_password') is-invalid @enderror"/>
                    <a href="javascript:void(0)" class="field_icon"><i class="fa fa-eye-slash " aria-hidden="true"></i></a>
                    @error('old_password')
                    <span role="alert" class="invalid-feedback">
                <strong>{{ $errors->first('old_password') }}</strong>
            </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <div class="col-md-6 show_hide_password">
                        <label for="password">Nouveau mot de passe</label>
                        <input type="password" name="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"/>
                        <a href="javascript:void(0)" class="field_icon"><i class="fa fa-eye-slash "
                                                                           aria-hidden="true"></i></a>
                        @error('password')
                        <span role="alert" class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
                        @enderror
                    </div>
                    <div class="col-md-6 show_hide_password">
                        <label for="password_confirmation">Confirmer mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control"/>
                        <a href="javascript:void(0)" class="field_icon"><i class="fa fa-eye-slash "
                                                                           aria-hidden="true"></i></a>
                    </div>
                </div>

                <h2>Informations personnelles</h2>
                <div class="form-group">
                    <label for="name">Prénom</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                           class="form-control @error('name') is-invalid @enderror">
                    @error('name')
                    <span role="alert" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" name="firstname" value="{{ Auth::user()->firstname }}"
                           class="form-control @error('firstname') is-invalid @enderror">
                    @error('firstname')
                    <span role="alert" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="genre">Civilité</label>
                    <div class="custom-control custom-radio  d-inline px-5">
                        <input class="custom-control-input" type="radio" name="sexe" id="exampleRadios1"
                               value="{{ Auth::user()->sexe }}" checked>
                        <label class="custom-control-label" for="exampleRadios1">
                            @if(Auth::user()->sexe == "M")
                                Male
                            @else
                                Female
                            @endif
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Adresse</label>
                    <input type="text" name="address" value="{{ Auth::user()->address }}"
                           class="form-control @error('address') is-invalid @enderror">
                    @error('address')
                    <span role="alert" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="city">Ville</label>
                    <input type="text" name="city" value="{{ Auth::user()->city }}"
                           class="form-control @error('city') is-invalid @enderror">
                    @error('city')
                    <span role="alert" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="zipcode">Code Postale</label>
                    <input type="text" name="zipcode" value="{{ Auth::user()->zipcode }}"
                           class="form-control @error('zipcode') is-invalid @enderror">
                    @error('zipcode')
                    <span role="alert" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="text" name="phone" value="{{ Auth::user()->phone }}"
                           class="form-control @error('phone') is-invalid @enderror">
                    @error('phone')
                    <span role="alert" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" name="pseudo" value="{{ Auth::user()->pseudo }}"
                           class="form-control" disabled>
                </div>
                <div class="form-group">
                    <label for="avatar">Avatar</label>

                    <input type="file" name="avatar" value="{{ Auth::user()->avatar }}"
                           class="form-control @error('avatar') is-invalid @enderror">
                    @error('avatar')
                    <span role="alert" class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary" style="background-color:gold; border-color:gold;">
                    Changer
                </button>
            </form>
        </div>
        <div class="row justify-content-center">


        </div>
    </div>
    <script>
        $(document).ready(function () {
            $(".show_hide_password a").on('click', function (event) {
                event.preventDefault();
                if ($(this).prev('input').attr("type") == "text") {
                    $(this).prev('input').attr('type', 'password');
                    $(this).find('i').addClass("fa-eye-slash");
                    $(this).find('i').removeClass("fa-eye");
                } else if ($(this).prev('input').attr("type") == "password") {
                    $(this).prev('input').attr('type', 'text');
                    $(this).find('i').removeClass("fa-eye-slash");
                    $(this).find('i').addClass("fa-eye");
                }
            });
        });
    </script>

@endsection


@section('scripts')
    @if( $errors->count() )

        <script>
            toastr.error('Invalid form inputs.');
        </script>

    @endif
@endsection
