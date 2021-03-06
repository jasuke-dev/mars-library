<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Kreait\Firebase\Firestore;
use Google\Cloud\Firestore\FirestoreClient;

class FirebaseController extends Controller
{
    protected $auth, $database;

    public function __construct()
    {
        // $factory = (new Factory)
        // ->withServiceAccount(__DIR__.'\config_Firebase.json')
        // ->withDatabaseUri('https://mars-library-26ce6-default-rtdb.asia-southeast1.firebasedatabase.app/');

        $this->auth = app('firebase.auth');
    }

    public function signUp()
    {
        $email = "angelicdemon@gmail.com";
        $pass = "anya123";

        try {
            $newUser = $this->auth->createUserWithEmailAndPassword($email, $pass);
            dd($newUser);
        } catch (\Throwable $e) {
            switch ($e->getMessage()) {
                case 'The email address is already in use by another account.':
                    dd("Email sudah digunakan.");
                    break;
                case 'A password must be a string with at least 6 characters.':
                    dd("Kata sandi minimal 6 karakter.");
                    break;
                default:
                    dd($e->getMessage());
                    break;
            }
        }
    }

    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        try {
            $signInResult = $this->auth->signInWithEmailAndPassword($credentials['email'], $credentials['password']);
            // dump($signInResult->data());
            $user =  app('firebase.firestore')->database()->collection('users')->document($signInResult->firebaseUserId())->snapshot();
            // membuat session firebaseUserId dengan isi userID
            if($user->data()['isAdmin']){
                Session::put('firebaseUserId', $signInResult->firebaseUserId());
                Session::put('admin',$user->data()['isAdmin']);
                Session::put('idToken', $signInResult->idToken());
                Session::save();
    
                return redirect()->intended('/dashboard');
            }else{
                return back()->with('loginError', 'Anda bukan admin');
            }
        } catch (\Throwable $e) {

            return back()->with('loginError', 'Invalid email or Password');
        }
    }

    public function logout(Request $request)
    {
        if (Session::has('firebaseUserId') && Session::has('idToken')) {
            // dd("User masih login.");
            $this->auth->revokeRefreshTokens(Session::get('firebaseUserId'));
            Session::forget('firebaseUserId');
            Session::forget('idToken');
            Session::save();
            $request->session()->regenerateToken();
            return redirect('/');
        } else {
            dd("User belum login.");
        }
    }
}
