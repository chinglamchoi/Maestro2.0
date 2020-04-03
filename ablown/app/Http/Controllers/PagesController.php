<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PagesController extends Controller
{
    public function index(){
        $title = 'ABlown';
        return view('pages.index')->with('title', $title);
    }
    public function about(){
        $data = array(
            'title' => 'ABlown',
            'creators' => ['ITO', 'Minnie', 'Grace']
        );
        return view('pages.about')->with($data);
    }
    public function add(){
        if(!auth()->user()){
            return redirect('/')->with('error', 'Access Denied');
        }else if(auth()->user()->type > 1){
            return redirect('/')->with('error', 'Access Denied');
        }else{
            return view('pages.add');
        }
    }
    public function user($id){
        if(!auth()->user()){
            return redirect('/')->with('error', 'Access Denied');
        }else{
            $user = User::find($id);
            if(!$user){
                return redirect('/'.auth()->user()->id);
            }
            return view('pages.user')->with('user', $user);
        }
    }
    public function userabout(Request $request){
        if(!auth()->user()){
            return redirect('/')->with('error', 'Access Denied');
        }else{
            $user = User::find(auth()->user()->id);
            $user->about = $request->input('about');
            $user->save();
            return redirect('/users/'.auth()->user()->id)->with('success', 'About Saved');
        }
    }
    public function userinterests(Request $request){
        if(!auth()->user()){
            return redirect('/')->with('error', 'Access Denied');
        }else{
            $user = User::find(auth()->user()->id);
            if($request->input('cars')){$user->cars = 1;}else{$user->cars = 0;}
            if($request->input('food')){$user->food = 1;}else{$user->food = 0;}
            if($request->input('math')){$user->math = 1;}else{$user->math = 0;}
            if($request->input('animals')){$user->animals = 1;}else{$user->animals = 0;}
            if($request->input('books')){$user->books = 1;}else{$user->books = 0;}
            $user->save();
            return redirect('/users/'.auth()->user()->id)->with('success', 'Interests Saved');
        }
    }
}
