<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Firestore;
use Illuminate\Support\Facades\Session;
use Google\Cloud\Firestore\FirestoreClient;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Kreait\Firebase\Value\Uid;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class UserPostController extends Controller
{    
    public function __construct()
    {
        // $factory = (new Factory)->withServiceAccount(__DIR__.'\config_Firebase.json');
        $this->db = app('firebase.firestore')->database();
        $this->auth = app('firebase.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = app('firebase.firestore')->database()->collection('users')->documents();
        return view('dashboard.pages.users.index', [
            'users' => $this->db->collection('users')->documents()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required',
            'username' => 'required',
            'telp' => 'required',
            'password' => 'required',
            'accountType' => 'required',
        ]);
        
        //register user
        $newUser = $this->auth->createUserWithEmailAndPassword($request['email'], $request['password']);        

        //buat user collection berdasar uid auth user
        $stuRef = app('firebase.firestore')->database()->collection('users')->Document($newUser->uid);
        $stuRef->set([
            'uid' => $newUser->uid,
            'email' => $request['email'],
            'username' => $request['username'],
            'telp' => $request['telp'],
            'isAdmin' => $request['accountType']
        ]);

        //uploud pdf
        // $pdf = $request->file('pdf');
        // $firebase_storage_path = 'pdf/';
        // $name = $stuRef->id();
        // $localfolder = public_path('firebase-temp-uplouds') . '/';
        // $extension = $pdf->getClientOriginalExtension();
        // $file = $name . '.'. $extension;
        // if($pdf->move($localfolder, $file)){
        //     $uploadedfile = fopen($localfolder.$file, 'r');
        //     app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $file]);
        //     //menghapus dari local
        //     unlink($localfolder . $file);
            
        // }else{
        //     echo 'error';
        // } 

        return redirect('/users')->with('success',"User Has been Added");
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
        return view('dashboard.pages.users.edit',[
            'oldData' => app('firebase.firestore')->database()->collection('users')->document($id)->snapshot()
        ]);
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
        $validatedData = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'accountType' => 'required',
            'telp' => 'required'
        ]);

        try{
            app('firebase.firestore')->database()->collection('books')->document($id)->update([
                [ 'path' => 'username' , 'value' => $request['username'] ],
                [ 'path' => 'email' , 'value' => $request['email'] ],
                [ 'path' => 'isAdmin' , 'value' => $request['accountType'] ],
                [ 'path' => 'telp' , 'value' => $request['telp'] ],
            ]); 

            return redirect('/users')->with('success',"Book Has been Edited");
        } catch(\Exception $e){
            return redirect('/users')
                ->with('error', 'Error during the creation!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //app('firebase.firestore')->database()->collection('users')->document($id)->delete();  
        return redirect('/users')->with('success',"Book Has been deleted");
    }
}
