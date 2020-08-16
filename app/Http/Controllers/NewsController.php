<?php

namespace App\Http\Controllers;

use App\News;
use App\Post;
use App\PostsMessages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class NewsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function create()
    {
        return view('news.new');
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
            'news' => 'required|string|min:4' ,
            'content_news' => 'required|string|max:225' ,
        ];

        $validate = Validator::make($request->except('_token') ,$rules);
        if ($validate->fails()) {
            return  redirect()->back()->withErrors($validate)->withInput();
        }
        DB::table('news')->insert(['news' => $request->news , 'content_news' => $request->content_news]);
        $news = DB::table('news')->orderBy('id' , 'desc')->get();
        return  redirect()->back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $new = DB::select( "select * from news where id = $id");
       return  view('news.new')->with('new', $new);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'news' => 'required|string|min:4' ,
            'content_news' => 'required|string|max:225' ,
        ];

        $validate = Validator::make($request->except('_token') ,$rules);
        if ($validate->fails()) {
            return  redirect()->back()->withErrors($validate)->withInput();
        }
        DB::table('news')->where('id',$id)->update(['news' => $request->news , 'content_news' => $request->content_news]);

        return  redirect('/news/create');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        DB::select("delete from news where id = $id");

        return  redirect()->back();
    }

    public function postMessage(Request $request)
    {
        try{
            $post_message = PostsMessages::create($request->all());

            $post_message = PostsMessages::with('from_user', 'to_user', 'post')->where([
                'id' => $post_message->id
            ])->first();

            return response()->json([
                'data' => $post_message,
                'success' => true
            ]);
        } catch (\Exception $e){
            return response()->json([
                'success' => false
            ]);
        }
    }
}
