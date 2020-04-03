<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Reply;
use App\User;

class TopicsController extends Controller
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
        $user = auth()->user();
        $type = $user->type;
        $topics = Topic::whereHas('user', function($query) use($type) {
            $query->where('type', '>=', $type);
        })->orderBy('updated_at','desc')->paginate(10);
        return view('forum.index')->with('topics', $topics);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forum.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);
        $topic = new Topic;
        $topic->user_id = auth()->user()->id;
        $topic->title = $request->input('title');
        $topic->save();
        $id = $topic->id;
        $reply = new Reply;
        $reply->topic_id = $id;
        $reply->user_id = auth()->user()->id;
        $reply->body = $request->input('body');
        $reply->save();
        return redirect('/forum/'.$id)->with('success', 'Topic Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = auth()->user();
        $type = $user->type;
        $topic = Topic::find($id);
        if($topic->user->type < $type){
            return redirect('/posts')->with('error', 'Access Denied');
        }
        $topic->replies = $topic->replies()->paginate(10);
        return view('forum.topic')->with('topic', $topic);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reply = Reply::find($id);
        if(auth()->user()->id !== $reply->user->id){
            return redirect('/forum')->with('error', 'Access Denied');
        }
        return view('forum.edit')->with('reply', $reply);
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
        $this->validate($request, [
            'body' => 'required',
        ]);
        $reply = Reply::find($id);
        if(auth()->user()->id !== $reply->user->id){
            return redirect('/forum')->with('error', 'Access Denied');
        }
        $reply->body = $request->input('body');
        $reply->save();
        return redirect('/forum/'.$reply->topic->id.'?page='.$request->input('page'))->with('success', 'Reply Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request, $id)
    {
        $user = auth()->user('id');
        $type = $user->type;
        $topic = Topic::find($id);
        if($topic->user->type < $type){
            return redirect('/posts')->with('error', 'Access Denied');
        }
        $this->validate($request, [
            'body' => 'required',
        ]);
        $reply = new Reply;
        $reply->topic_id = $id;
        $reply->user_id = auth()->user()->id;
        $reply->body = $request->input('body');
        $reply->save();
        $topic->touch();
        return redirect('/forum/'.$id.'?page='.$request->input('page'))->with('success', 'Replied');
    }
}
