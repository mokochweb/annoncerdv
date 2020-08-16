<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'birthday' => ['required', 'date', 'before:-18 years'],
            'city' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string','unique:users'],
            'zipcode' => ['nullable', 'integer'],
            'pseudo' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:25',
                'confirmed',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/',
            ],
            'avatar' => ['image', 'mimes:jpg,jpeg,bmp,png,svg', 'max:3000'] ,
            'sexe' => ['required', Rule::in(['F','M'])],
            'g-recaptcha-response' => 'required|recaptcha'
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(request()->has('avatar')){
            $avataruploaded = request()->file('avatar');
            $avatarname = time() . '.' . $avataruploaded->getClientOriginalExtension();
            $avatarpath = public_path('/images/');
            $avataruploaded->move($avatarpath, $avatarname);
            return User::create([
                'name' => $data['name'],
                'firstname' => $data['firstname'],
                'address' => $data['address'],
                'city' => $data['city'],
                'phone' => $data['phone'],
                'zipcode' => $data['zipcode'],
                'pseudo' => $data['pseudo'],
                'birthday' => $data['birthday'],
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'avatar' => '/images/' . $avatarname,
                'sexe' => $data['sexe'],
            ]);
        }
        if($data['sexe'] == "M"){
            $avatar = "/images/avatar-male.jpg";
        }else{
            $avatar = "/images/Female-Avatar.jpg";
        }
        return User::create([
            'name' => $data['name'],
            'firstname' => $data['firstname'],
            'address' => $data['address'],
            'city' => $data['city'],
            'phone' => $data['phone'],
            'zipcode' => $data['zipcode'],
            'pseudo' => $data['pseudo'],
            'birthday' => $data['birthday'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'sexe' => $data['sexe'],
            'avatar' => $avatar,
        ]);
    }
}
