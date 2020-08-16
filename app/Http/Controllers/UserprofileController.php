<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserprofileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        return view('usersprofile.index');
    }

    public function update(Request $request, $id) {

        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string'],
            'zipcode' => ['nullable', 'string', 'max:255'],
            'sexe' => ['required'],
            'pseudo' => ['required', 'string', 'max:255', "unique:users,pseudo,$id"],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,$id"],
        ]);

        if($request->has('avatar')){
            $avataruploaded = request()->file('avatar');
            $avatarname = time() . '.' . $avataruploaded->getClientOriginalExtension();
            $avatarpath = public_path('/images/');
            $avataruploaded->move($avatarpath, $avatarname);

            $user->name = $request->get('name');
            $user->firstname = $request->get('firstname');
            $user->address = $request->get('address');
            $user->city = $request->get('city');
            $user->phone = $request->get('phone');
            $user->zipcode = $request->get('zipcode');
            $user->email = $request->get('email');
            //$user->pseudo = $request->get('pseudo');
            //$user->sexe = $request->get('sexe');
            $user->avatar = '/images/' . $avatarname ;
            $user->save();

        } else {
            $user->name = $request->get('name');
            $user->firstname = $request->get('firstname');
            $user->address = $request->get('address');
            $user->city = $request->get('city');
            $user->phone = $request->get('phone');
            $user->zipcode = $request->get('zipcode');
            $user->email = $request->get('email');
            //$user->pseudo = $request->get('pseudo');
            //$user->sexe = $request->get('sexe');
            $user->save();
        }

        /* Check if password fields are filled */
        if($request->has('old_password') and !empty($request->post('old_password')))
        {
            if( !Hash::check($request->post('old_password'), $user->password) )
            {
                return back()->withErrors([
                    'old_password' => 'Invalid old password'
                ]);
            }

            $request->validate([
                'password' => 'required|confirmed'
            ]);

            if($request->post('old_password') == $request->post('password'))
            {
                return back()->withErrors([
                    'password' => 'New password should be differnet'
                ]);
            }

            $user->password = Hash::make($request->post('password'));
            $user->save();
        }

        toastr()->success('Votre profile a était modifié avec succès!');
        return redirect('users')->with('status', 'Profile updated!');
    }

}
