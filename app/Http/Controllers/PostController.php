<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostsMessages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PostController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $posts = Post::with('user', 'messages', 'messages.from_user', 'messages.to_user')->where('user_id', $user_id)->paginate(10); 
        return  view('posts', compact('posts') );
    }

  public function my_ads(){
        $posts = Post::with('user', 'messages', 'messages.from_user', 'messages.to_user')->get();
        return view('posts/my_ads', compact('posts') );
    }

    public function ajaxadress($adress) {
        return response()->json(['data' => DB::table('adress')->select(['adress', 'id'])->where('adress', 'like' , "%$adress%")->get()] , 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return  view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|min:4' ,
            'quantite1' => 'required|numeric' ,
            'quantite2' => 'required|numeric' ,
            'date_b'  => 'nullable|date|after_or_equal:tomorrow',
            'date_e' => 'nullable|date|after_or_equal:date_b',
            'time_b' => 'nullable',
            'time_e' => 'nullable',
            'adressajax' => 'required|string',
        ];

        $validate = Validator::make($request->except('_token') ,$rules);
        if ($validate->fails()) {
           return  redirect()->back()->withErrors($validate)->withInput();
        }
       Post::create([
           'titre' => $request->title ,
           'qte' => $request->quantite1 ,
           'quantite2' => $request->quantite2 ,
           'daterdvbegin' => $request->date_b ,
           'daterdvend' => $request->date_e ,
           'Hbeginrdv' => $request->time_b ,
           'Hendrdv' => $request->time_e ,
           'adresse' => $request->adressajax ,
           'user_id' => Auth::user()->id ,
       ]);

        toastr()->success('Votre annonce a était créer avec succès');
        return  redirect('/posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = DB::select('select * from posts where id = '.$id);
        return view('posts.create')->with('id',$id)->with('post',$post[0]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update2(Request $request, $id)
    {
        $rules = [
            'title' => 'required|string|min:4' ,
            'quantite1' => 'required|numeric' ,
            'quantite2' => 'required|numeric' ,
            'date_b'  => 'nullable|date|after_or_equal:tomorrow',
            'date_e' => 'nullable|date|after_or_equal:date_b',
            'adressajax' => 'required|string',
        ];

        $validate = Validator::make($request->except('_token') ,$rules);
        if ($validate->fails()) {
            return  redirect()->back()->withErrors($validate)->withInput();
        }
        DB::table('posts')->where('id',$id)->update([
            'titre' => $request->title ,
            'qte' => $request->quantite1 ,
            'quantite2' => $request->quantite2 ,
            'daterdvbegin' => $request->date_b ,
            'daterdvend' => $request->date_e ,
            'Hbeginrdv' => $request->time_b ,
            'Hendrdv' => $request->time_e ,
            'adresse' => $request->adressajax ,
            'user_id' => Auth::user()->id ,
        ]);
        return  redirect('/home')->with('success', 'Votre annonce à était modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {  
         DB::table('posts')->where('id',$id)->delete();
        return back()->with('success','Votre annonce a était supprimé!');
    }

    public function getMessages()
    { 
        $posts = PostsMessages::with('from_user', 'to_user')->get(); 
        return  response()->json($posts);
    }
}
