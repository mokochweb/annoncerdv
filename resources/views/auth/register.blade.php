@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h1 style="border-bottom: solid yellow;"><strong>Formulaire d'inscription</strong></h1>
   <div class="container">
                            <div class="container">
  <div class="row justify-content-start">
  
  </div>


  <div class="row justify-content-between">
  <small><strong>Ces données permettent à la société d'offir un service client optimal, notamment en
                            optimisant les résultats dans vos recherches.</strong></small>
    <div class="col-4">
    <a href="{{ route('welcome') }}" class="annulerinscription" style="background-color:#afb8b5;border-radius:28px;border:1px solid #afb8b5;display:inline-block;cursor:pointer;color:#ffffff;font-family:Arial;font-size:9px;font-weight:bold;padding:5px 6px;text-decoration:none;text-shadow:0px 1px 0px #afb8b5;:hover background-color:#6c7c7c;:active position:relative; top:1px;">Annuler l'inscription</a>
    </div>
  </div>
</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        <h3><strong>Vos identifiants</strong></h3>
                        <div class="form-group row">
                            <label for="email" class="col-md-2 col-form-label text-md-right">Adresse mail</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email">
                                <span>
                                    <img class="info_icon" src="{{asset('icons/info.png')}}"
                                         title="L’adresse mail permet de vous connecter au service.
L’adresse mail vous permet d’échanger avec les autres utilisateurs
L’adresse mail n’est pas visible des autres utilisateurs.">
                                </span>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-2 col-form-label text-md-right">Mot de passe</label>

                            <div class="col-md-8 show_hide_password">
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required autocomplete="new-password">
                                <a href="javascript:void(0)" class="field_icon"><i class="fa fa-eye-slash "
                                                                                   aria-hidden="true"></i></a>
                                <span><img class="info_icon" src="{{asset('icons/info.png')}}" title="Mot de passe. Doit contenir au moins :
8 caractères minimum
25 caractères maximum
1 chiffre minimum
1 lettre majuscule minimum
1 caractère spécial minimum: &~#‘{}[]()-|`_\/^ @ = +$ % *?, .  ;:!"></span>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-2 col-form-label text-md-right">Confirmation mot
                                de passe</label>

                            <div class="col-md-8 show_hide_password">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">
                                <a href="javascript:void(0)" class="field_icon"><i class="fa fa-eye-slash "
                                                                                   aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                        <h3><strong>Informations personnelles</strong></h3>
                        <div class="form-group row">
                            <label for="sex" class="col-md-2 col-form-label text-md-right">Civilité</label>
                            <div class="col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sexe" id="exampleRadios1"
                                           value="M" checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Male
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sexe" id="exampleRadios2"
                                           value="F">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Female
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-2 col-form-label text-md-right">Prénom</label>
                            <div class="col-md-8">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstname" class="col-md-2 col-form-label text-md-right">Nom</label>

                            <div class="col-md-8">
                                <input id="firstname" type="text"
                                       class="form-control @error('firstname') is-invalid @enderror" name="firstname"
                                       value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>
                                @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-md-2 col-form-label text-md-right">Adresse</label>
                            <div class="col-md-8">
                                <input id="address" type="text"
                                       class="form-control @error('address') is-invalid @enderror" name="address"
                                       value="{{ old('address') }}" autocomplete="address" autofocus>
                                <span><img class="info_icon" src="{{asset('icons/info.png')}}" title='L’adresse postale nous permet de :
￭ faire des statistiques et analyses marketing, afin de comprendre comment vous utilisez nos services.
￭ vous proposez du contenu personnalisé et améliorer votre expérience utilisateur
￭ vous envoyez des annonces parues sur notre site, près de chez vous  et susceptibles de vous intéresser.
Vos données sont modifiables, supprimables à tout moment depuis votre espace mon compte "mon profil"'></span>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <p style="padding-top: 7px;padding-left: 21px;">(facultatif)</p>

                        </div>

                        <div class="form-group row">
                            <label for="city" class="col-md-2 col-form-label text-md-right">Ville</label>
                            <div class="col-md-8">
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror"
                                       name="city" value="{{ old('city') }}" autocomplete="city" autofocus>
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <p style="padding-top: 7px;padding-left: 21px;">(facultatif)</p>

                        </div>
                        <div class="form-group row">
                            <label for="zipcode" class="col-md-2 col-form-label text-md-right">Code postale</label>
                            <div class="col-md-8">
                                <input id="zipcode" type="text"
                                       class="form-control @error('zipcode') is-invalid @enderror" name="zipcode"
                                       value="{{ old('zipcode') }}" autocomplete="zipcode" autofocus>
                                @error('zipcode')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <p style="padding-top: 7px;padding-left: 21px;">(facultatif)</p>

                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-2 col-form-label text-md-right">Numéro de téléphone</label>
                            <div class="col-md-8">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus>
                                <span>
                                    <img class="info_icon" src="{{asset('icons/info.png')}}"
                                           title='Si vous souhaitez être contacté par téléphone,
                                            sms par les autres utilisateurs du site qui répondernt à vos annonces.
                                            Vos données sont modifiables,
                                             supprimables  à tout moment depuis votre espace mon compte " mon profil" '>
                                </span>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <p style="padding-top: 7px;padding-left: 21px;">(facultatif)</p>

                        </div>

                        <div class="form-group row">
                            <label for="birthday" class="col-md-2 col-form-label text-md-right">Date de
                                naissance</label>
                            <div class="col-md-8">
                                <input id="birthday" type="date"
                                       class="form-control @error('birthday') is-invalid @enderror" name="birthday"
                                       value="{{ old('birthday') }}" required autocomplete="birthday" autofocus>
                                <span><img class="info_icon" src="{{asset('icons/info.png')}}"
                                           title="Il faut avoir au minimum 18 ans pour s'inscrire"></span>
                                @error('birthday')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="pseudo" class="col-md-2 col-form-label text-md-right">Nom d'utilisateur
                                (pseudo)</label>
                            <div class="col-md-8">
                                <input id="pseudo" type="text"
                                       class="form-control @error('pseudo') is-invalid @enderror" name="pseudo"
                                       value="{{ old('pseudo') }}" required autocomplete="pseudo" autofocus>
                                <span><img class="info_icon" src="{{asset('icons/info.png')}}"
                                           title="le pseudo s'affiche dans l'annonce. A défaut de pseudo, votre nom s'affiche."></span>
                                @error('pseudo')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="avatar" class="col-md-2 col-form-label text-md-right"></label>
                            <div class="col-md-8">
                                <input id="avatar" type="file"
                                       class="form-control @error('avatar') is-invalid @enderror" name="avatar"
                                       autocomplete="avatar" accept="image/*">
                                @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <p style="padding-top: 7px;padding-left: 21px;">(facultatif)</p>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 offset-md-4">
                                <div class="g-recaptcha"
                                     data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}">
                                </div>
                                <span role="alert" class="invalid-feedback d-block">
                                    @error('g-recaptcha-response')
                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                    @enderror
                                </span>
                            </div>
                        </div>
                        <div class="col-md-8 offset-md-2">
                            <input type="checkbox" id="scales" name="scales" checked>
                            <label>Je souhaite recevoir des offres des partenaires du site susceptibles de
                                m'intéresser</label>
                        </div>
                        <div class="col-md-8 offset-md-2">
                            <input type="checkbox" id="scales" name="scales" checked required>
                            <label>Je déclare avoir lu <a href="#">les conditions générales de services</a> et <a
                                    href="#">les conditions d'utilisations</a></label>

                        </div>
                        <div class="col-md-8 offset-md-2">
                            <input type="checkbox" id="scales" name="scales" checked required>
                            <label>J'accepte les <a href="#">Conditions Générales de Vente</a> et les <a href="#">Conditions
                                    Générales d'Utilisations</a></label>

                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8x` offset-md-4">
                                <button type="submit" class="btn btn-primary"
                                        style="background-color:gold; border-color:gold;">
                                    Crée mon compte
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
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
    <script src='https://www.google.com/recaptcha/api.js'></script>

@endsection


