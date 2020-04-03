<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $key = 'AutisticKey';
        if($data['r_type']=='0'){
            if(auth()->user()){
                return Validator::make($data, ['r_type' => 'in:1'], ['in' => 'You are already logged in']);
            }
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255', 'alpha_num'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'key' => 'required|in:'.$key,
            ]);
        }else{
            if(!auth()->user()){
                return Validator::make($data, ['r_type' => 'in:1'], ['in' => 'Access Denied']);
            }
            if(auth()->user()->type > 1){
                return Validator::make($data, ['r_type' => 'in:1'], ['in' => 'Access Denied.']);
            }
            return Validator::make($data, [
                'name' => ['required', 'string', 'max:255', 'alpha_num'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'email2' => ['required', 'string', 'email', 'max:255', 'unique:users,email', 'different:email'],
                'password2' => ['required', 'string', 'min:8', 'confirmed'],
                'key' => 'required|in:'.$key,
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if($data['r_type']=='0'){
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'type' => 1,
                'link' => 0,
                'about' => 'My about.',
                'cars' => 0,
                'food' => 0,
                'math' => 0,
                'animals' => 0,
                'books' => 0,
            ]);
        }
        $student = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => 3,
            'link' => auth()->user()->id,
            'about' => 'My about.',
            'cars' => 0,
            'food' => 0,
            'math' => 0,
            'animals' => 0,
            'books' => 0,
        ]);
        User::create([
            'name' => $data['name']."'s parent",
            'email' => $data['email2'],
            'password' => Hash::make($data['password2']),
            'type' => 2,
            'link' => $student->id,
            'about' => 'My about.',
            'cars' => 0,
            'food' => 0,
            'math' => 0,
            'animals' => 0,
            'books' => 0,
        ]);
        return auth()->user();
    }
}
