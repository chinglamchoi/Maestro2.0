<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\User;
use App\Question;
use App\Submission;
use App\Answer;
use Http_Request2;

class CoursesController extends Controller
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
        $subs = auth()->user()->submissions;
        if(count($subs) > 0){
            if(!$subs->last()->completed){
                return redirect('/courses/'.$subs->last()->course->id)->with('error', 'Please finish this course');
            }
        }
        $type = auth()->user()->type;
        if($type == 1){
            $courses = Course::orderBy('id', 'desc')->where('published', '1')->paginate(10);
        }else if($type == 3){
            $parent = User::where('link', auth()->user()->id)->first()->id;
            $courses = Course::whereHas('user', function($query) use($parent) {
                $query->where('type', '1')->orWhere('user_id', $parent);
            })->orderBy('id', 'desc')->where('published', '1')->paginate(10);
        }else{
            $id = auth()->user()->id;
            $courses = Course::whereHas('user', function($query) use($id) {
                $query->where('type', '1')->orWhere('user_id', $id);
            })->orderBy('id', 'desc')->where('published', '1')->paginate(10);
        }
        return view('courses.index')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        if($user->type > 2){
            return redirect('/courses')->with('error', 'Access Denied');
        }else{
            $courses = $user->courses;
            if(count($courses) > 0){
                if(!$courses->last()->published){
                    return redirect('/courses/'.$courses->last()->id)->with('error', 'Please finish making this course');
                }
            }
            return view('courses.create');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->type > 2){
            return redirect('/courses')->with('error', 'Access Denied');
        }else{
            $courses = auth()->user()->courses;
            if(count($courses) > 0){
                if(!$courses->last()->published){
                    return redirect('/courses/'.$courses->last()->id)->with('error', 'Please finish making this course');
                }
            }
        }
        $this->validate($request, [
            'name' => 'required',
        ]);
        $course = new Course;
        $course->user_id = auth()->user()->id;
        $course->name = $request->input('name');
        $course->published = 0;
        $course->save();
        $id = $course->id;
        return redirect('/courses/'.$id)->with('success', 'Course Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        $creator = $course->user;
        $user = auth()->user();
        if($creator->type == 2 and $user->type > 1){
            if($user->id != $creator->id and $user->id != $creator->link){
                return redirect('/courses')->with('error', 'Access Denied');
            }
        }
        if($course->published){
            $subs = $user->submissions;
            if(count($subs) > 0){
                if(!$subs->last()->completed){
                    if($id == $subs->last()->course->id){
                        return redirect('/courses/'.$subs->last()->course->id.'/answer');
                    }
                    return redirect('/courses/'.$subs->last()->course->id.'/answer')->with('error', 'Please finish this course');
                }
            }
            return view('courses.start')->with('course', $course);
        }else if($creator->id == $user->id){
            $course->questions = $course->questions()->paginate(10);
            return view('courses.edit')->with('course', $course);
        }
        return redirect('/courses')->with('error', 'Access Denied');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($user->id == $creator->id){
            return view('courses.start')->with('course', $course);
        }
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
        //
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
    public function question(Request $request, $id)
    {
        $user = auth()->user()->id;
        $course = Course::find($id);
        if($course->user->id != $user){
            return redirect('/courses')->with('error', 'Access Denied');
        }
        $this->validate($request, [
                    'question' => 'required',
                    'image' => 'image|nullable|max:1999',
                    'a' => 'required',
                    'b' => 'required',
                    'c' => 'required',
                    'd' => 'required',
                    'answer' => 'required|integer|between:1,4',
                ]);
        $question = new Question;
        $question->course_id = $id;
        $question->question = $request->input('question');
        $question->a = $request->input('a');
        $question->b = $request->input('b');
        $question->c = $request->input('c');
        $question->d = $request->input('d');
        $question->answer = $request->input('answer');
        $question->save();
        if($request->hasFile('image')){
            $extension = $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('storage/images/questions', $question->id.'.'.$extension, 'public_resources');
            $question->ext = $extension;
            $question->save();
        }
        return redirect('/courses/'.$id)->with('success', 'Question added');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function answer($id)
    {
        $course = Course::find($id);
        $user = auth()->user();
        $creator = $course->user;
        $course->questions = $course->questions()->paginate(1);
        if($creator->type == 2 and $user->type > 1){
            if($user->id != $creator->id and $user->id != $creator->link){
                return redirect('/courses')->with('error', 'Access Denied');
            }
        }
        $subs = $user->submissions;
        if($course->published && count($subs) > 0){
            if($subs->last()->course->id == $course->id && !$subs->last()->completed){
                return view('courses.question')->with('course', $course);
            }
        }
        return redirect('/courses')->with('error', 'Access Denied');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function publish($id)
    {
        $course = Course::find($id);
        $user = auth()->user();
        $creator = $course->user;
        if($creator->id == $user->id){
            if(count($course->questions) == 0){
                return redirect('/courses/'.$id)->with('error', 'Please include at least 1 question');
            }
            $course->published = 1;
            $course->save();
            return redirect('/courses')->with('success', 'Course published');
        }
        return redirect('/courses')->with('error', 'Access Denied');
    }

    public function start($id)
    {
        $course = Course::find($id);
        $user = auth()->user();
        $creator = $course->user;
        if($creator->type == 2 and $user->type > 1){
            if($user->id != $creator->id and $user->id != $creator->link){
                return redirect('/courses')->with('error', 'Access Denied');
            }
        }
        if($course->published){
            $subs = $user->submissions;
            if(count($subs) > 0){
                if(!$subs->last()->completed){
                    return redirect('/courses/'.$subs->last()->course->id.'/answer')->with('error', 'Please finish this course');
                }
            }
            $sub = new Submission;
            $sub->user_id = $user->id;
            $sub->course_id = $id;
            $sub->completed = 0;
            $sub->save();
            $questions = Course::find($id)->questions;
            foreach($questions as $question){
                $ans = new Answer;
                $ans->submission_id = $sub->id;
                $ans->question_id = $question->id;
                $ans->answer = 0;
                $ans->save();
            }
            return redirect('/courses/'.$sub->course->id.'/answer')->with('course', $course);
        }
        return redirect('/courses')->with('error', 'Access Denied');
    }

    public function save(Request $request, $id)
    {
        $this->validate($request, [
            'answer' => 'nullable|integer|between:1,4',
        ]);
        $subs = auth()->user()->submissions;
        if(count($subs) > 0){
            if(!$subs->last()->completed){
                $course = Question::find($id)->course;
                if($subs->last()->course->id == $course->id){
                    $answer = $subs->last()->answers->where('question_id', $id)->first();
                    $answer->answer = $request->input('answer');
                    $answer->save();
                    return redirect('/courses/'.$course->id.'/answer?page='.$request->input('page'));
                }
            }
        }
        return redirect('/courses')->with('error', 'Access Denied');
    }
    public function submit()
    {
        $user = auth()->user();
        $subs = $user->submissions;
        if(count($subs) > 0){
            $sub = $subs->last();
            if(!$sub->completed){
                $sub->completed = 1;
                $sub->save();
                return redirect('/courses')->with('success', 'Course submitted');
            }
        }
        return redirect('/courses')->with('error', 'Access Denied');
    }
    public function submissions()
    {
        $user = auth()->user();
        if($user->type == 1){
            $submissions = Submission::orderBy('updated_at', 'desc')->paginate(50);
        }else if($user->type == 2){
            $submissions = Submission::orderBy('updated_at', 'desc')->where('user_id', $user->id)->orWhere('user_id', $user->link)->paginate(50);
        }else{
            $submissions = Submission::orderBy('updated_at', 'desc')->where('user_id', $user->id)->paginate(50); 
        }
        return view('courses.submissions')->with('submissions', $submissions);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function solution($id)
    {
        $course = Course::find($id);
        $user = auth()->user();
        $creator = $course->user;
        $course->questions = $course->questions()->paginate(1);
        if($user->type == 1 || $user->id == $creator->id){
            return view('courses.see')->with('course', $course);
        }
        return redirect('/courses')->with('error', 'Access Denied');
    }
    public function submission($id)
    {
        $user = auth()->user();
        $submission = Submission::find($id);
        if(($user->type == 2 && ($submission->user->id != $user->id && $submission->user->id != $user->link)) || ($user->type == 3 && $submission->user->id != $user->id)){
        return redirect('/courses')->with('error', 'Access Denied');
        }
        $submission->answers = $submission->answers()->paginate(50);
        return view('courses.submission')->with('submission', $submission);
    }
    public function recognition(Request $request)
    {
        if(!count($request->all())){
            return view('recognition.upload');
        }
        $this->validate($request, ['image' => 'image|required|max:1999']);
        $user = auth()->user();
        $filename = $user->id.'.'.$request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('storage/images/face', $filename, 'public_resources');
        // Replace <Subscription Key> with a valid subscription key.
        $ocpApimSubscriptionKey = '26b177f59be84140876fe63220e713d6';
        // Replace <My Endpoint String> with the string in your endpoint URL.
        $uriBase = 'https://westcentralus.api.cognitive.microsoft.com/face/v1.0';
        $imageUrl = "http://ablown.000webhostapp.com/storage/images/questions/33.jpg";
            //"storage/images/face/$filename";
        // This sample uses the PHP5 HTTP_Request2 package (https://pear.php.net/package/HTTP_Request2).
        require_once 'HTTP/Request2.php';
        $request = new Http_Request2($uriBase . '/detect'); $url = $request->getUrl();
        $headers = array( // Request headers
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $ocpApimSubscriptionKey
        ); $request->setHeader($headers);
        $parameters = array( // Request parameters
            'returnFaceId' => 'true',
            'returnFaceLandmarks' => 'false',
            'returnFaceAttributes' => 'age,gender,headPose,smile,facialHair,glasses,' .
            'emotion,hair,makeup,occlusion,accessories,blur,exposure,noise');
        $url->setQueryVariables($parameters);
        $request->setMethod(HTTP_Request2::METHOD_POST);
        // Request body parameters
        $body = json_encode(array('url' => $imageUrl));
        // Request body
        $request->setBody($body);
        $response = $request->send();
        $faces = json_decode($response->getBody());
        try{
            count($faces);
            return view('recognition.results')->with('faces', $faces)->with('filename', $filename);
        }catch(\Exception $error){
            return view('recognition.upload')->with('error', 'Error');
        }
    }
}