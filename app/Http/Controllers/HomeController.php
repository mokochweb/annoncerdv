<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array();
        $data['posts'] = Post::with('user', 'messages', 'messages.from_user', 'messages.to_user')->paginate(10);

        return view('home', $data);
    }

    public function about_us()
    {
        $data = array();
        $data['css_includes'] = 'https://fonts.googleapis.com/css?family=Roboto';
         return view('about_us', $data);
    }

    public function profile($id = null)
    {
        if($id == null) {
            return view('usersprofile.index');

        }else {
            return view('usersprofile.index', compact('id'));

        }

    }
    public function contact_us()
    {
        $data = array();
        //$data['js_includes'] = 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js';
         return view('contact_us', $data);
    }

    function post_contact_us(Request $request) {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required'
        ]);

        $name = $request->name;
        $email = $request->email;

        $viewData['name'] = $request->name;
        $viewData['email'] = $request->email;
        $viewData['subject'] = $request->subject;
        $viewData['body_msg'] = $request->message;
        //$m->from(env('FROM_EMAIL'),'Contact us email');
          // Mail::send('email.contact_us',$viewData, function ($m) use ($email) {
          //      $m->from('Contact us email');
          //      $m->to('Mokoch.web@gmail.com')->subject('Contact us form');
          //  });

       return redirect('contact_us')->with('success','Contact us submit successfully.');
        }

}