<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\PostsMessages;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
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
        $user_id = Auth::user()->id;
         $from_users = PostsMessages::select('*')
            ->with('post.user', 'post', 'to_user', 'from_user')
            ->where('to_user_id', $user_id)
            ->orWhere('from_user_id', $user_id)
            ->groupBy('post_id')
            ->orderBy('created_at', 'DESC')
            ->get();

        $from_users = json_encode($from_users);
        return view('messages.messagerie', [
            'from' => $from_users,
            'no_active' => true,
            'active' => null
        ]);
    }

    public function getData()
    {
        $user_id = Auth::user()->id;
        $from_users = PostsMessages::select('*')
            ->with('post.user', 'post', 'to_user', 'from_user')
            ->where('to_user_id', $user_id)
            ->orWhere('from_user_id', $user_id)
            ->groupBy('post_id')
            ->orderBy('created_at', 'DESC')
            ->get();
        return json_encode($from_users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        User::findOrFail($request->post('conversation_id'));
        Post::findOrFail($request->post('post_id'));

        $message = $request->post('message');
        $post_message = PostsMessages::create([
            'to_user_id' => $request->conversation_id,
            'from_user_id' => \Auth::user()->id,
            'message' => $message,
            'post_id' => $request->post('post_id')
        ]);

        $return = collect($post_message->only(['id', 'post_id', 'to_user_id']) + ['class' => PostsMessages::REPLY_CLASS, 'avatar' => url($post_message->from_user->avatar)]);
        return collect($return)->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        User::findOrFail($id);
        $user_id = \Auth::user()->id;
        $from_users = PostsMessages::select('from_user_id', 'to_user_id')
            ->whereRaw("(to_user_id = $user_id OR from_user_id = $user_id) and from_user_id != $user_id")
            ->groupBy('from_user_id')
            ->get();
        //dd($from_users);
        $active_chat_id = $id;
        $messages = PostsMessages::whereRaw("(from_user_id = $id AND to_user_id = $user_id) OR (from_user_id = $user_id AND to_user_id = $id)")->get();
        //dd($messages);
        return view('messages.index', compact('from_users', 'active_chat_id', 'messages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = \Auth::user()->id;

        User::findOrFail($id);
        PostsMessages::whereRaw("(from_user_id = $id AND to_user_id = $user_id) OR (from_user_id = $user_id AND to_user_id = $id)")->delete();

        toastr()->success('Conversation deleted successfully.');

        return redirect()->route('messages.index');
    }

    public function newMessage(Request $request, $id)
    {
        $user_id = \Auth::user()->id;
        $last_message_id = $request->get('last_message_id');
        $messages = PostsMessages::whereRaw("( (from_user_id = $id AND to_user_id = $user_id) OR (from_user_id = $user_id AND to_user_id = $id) ) AND id > $last_message_id")->get();
        $messages_collection = collect();

        foreach ($messages as $message) {
            $messages_collection->push([
                'id' => $message->id,
                'message' => $message->message,
                'class' => $message->from_user_id == $user_id ? PostsMessages::REPLY_CLASS : PostsMessages::SENT_CLASS,
                'avatar' => url($message->from_user->avatar),
                'post_id' => $message->post_id
            ]);
        }

        return $messages_collection->toJson();
    }

    public function readMessage(Request $request)
    {
        $user_id = \Auth::user()->id;
        $results = DB::update(DB::raw("update posts_messages SET seen_by = CONCAT(seen_by, ',$user_id') where to_user_id = $user_id and seen_by not like '%$user_id%'"));

    }

    /*
     * Send message for all
     */

    public function messageAll(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $id = explode(',', $id);
            $post_message = PostsMessages::create([
                'to_user_id' => $id[1],
                'from_user_id' => Auth::user()->id,
                'message' => $request->msg,
                'post_id' => $id[0]
            ]);
        }
        return back()->with('success', 'votre message a été envoyé avec succès');
    }

    public function messagePostInfo($id)
    {
        $post = PostsMessages::select(
            '*',
            DB::raw('DATE_FORMAT(created_at, "%d-%b-%Y") as date_created_at'),
            DB::raw('DATE_FORMAT(created_at, "%H:%i:%s") as time_created_at'),
        )
            ->with('post.user', 'to_user', 'from_user')
            ->where([['to_user_id', Auth::id()], ['post_id', $id]])
            ->orWhere([['from_user_id', Auth::id()], ['post_id', $id]])
            ->get();
        return json_encode($post);
    }

    /*
     * Chat envoi d'un message a un seul user
     */

    public function sendMessage(Request $request)
    {
        $post_message = PostsMessages::create([
            'to_user_id' => $request->toUserId,
            'from_user_id' => Auth::user()->id,
            'message' => $request->message,
            'post_id' => $request->postId
        ]);

        return true;
    }

    /*
    * Chat envoi d'un message a un plusieurs users
    */
    public function messageGroup(Request $request)
    {


        foreach ($request->checkboxListId as $message) {
            if ($message['from_user_id'] == Auth::id()) {
                $toUserId = $message['to_user_id'];
            } else {
                $toUserId = $message['from_user_id'];
            }
            $post_message = PostsMessages::create([
                'to_user_id' => $toUserId,
                'from_user_id' => Auth::id(),
                'message' => $request->message,
                'post_id' => $message['post_id']
            ]);
        }
        return true;
    }

    /*
     * Delete message list
     */
    public function deleteMessage(Request $request)
    {

        foreach ($request->id as $message) {
            $data = PostsMessages::where('id', $message);
            $data->delete();
        }
        return true;
    }
}
