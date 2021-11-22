<?php

namespace App\Http\Controllers;

use DateTime;
use Kreait\Firebase\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Firestore;
use Illuminate\Support\Facades\Session;
use Google\Cloud\Firestore\FirestoreClient;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class BookPostController extends Controller
{
    //protected $auth, $database;

    // public function __construct(Firestore $firestore)//ini cara dokumentasi
    // {
    //     $factory = (new Factory)
    //     ->withServiceAccount(__DIR__.'\config_Firebase.json')
    //     ->withDatabaseUri('https://mars-library-26ce6-default-rtdb.asia-southeast1.firebasedatabase.app/');

    //     $this->auth = $factory->createAuth();
    //     $this->database = $factory->createDatabase(); 

    //     cara dokumentasi gagal jadi pake app('firebase.firestore')
    //     $this->firestore = $firestore;
        
        
    // }
    protected $db;
    public function __construct()
    {
        // $factory = (new Factory)->withServiceAccount(__DIR__.'\config_Firebase.json');
        $this->db = app('firebase.firestore')->database();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = app('firebase.firestore')->database()->collection('books')->documents();
        //dd($books);
        return view('dashboard.pages.books.index', [
            'books' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.pages.books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uid = Str::uuid();
        $validatedData = $request->validate([
            'cover' => 'required',
            'judul' => 'required',
            'tahun' => 'required',
            'stok' => 'required',
            'pengarang' => 'required',
            'sinopsis' => 'required',
        ]);
        date_default_timezone_set("Asia/Bangkok");

        
        //cara web tutorial firestore
        $stuRef = app('firebase.firestore')->database()->collection('books')->newDocument();
        $stuRef->set([
            'cover' => $request['cover'],
            'judul' => $request['judul'],
            'pengarang' => $request['pengarang'],
            'tahun_terbit' => $request['tahun'],
            'stok' => $request['stok'],
            'sinopsis' => $request['sinopsis'],
            'time' => date("Y:m:d:H:i:s"),
            'rating' => 0
        ]);
        
        return redirect('/books')->with('success',"Book Has been Added");
        // mengolah inputan genre
        // $genre_arr = explode("," , $request['genre']);
        // foreach ($genre_arr as $genre){
        //     $genre_buku = app('firebase.firestore')->database()->collection('buku_genre')->newDocument();
        //     $genre_buku->set([
        //         'buku' => $stuRef,
        //         'genre_id' => $genre //masih kurang buku_id dan genre references
        //     ]);
        // }

        //uploud image
        // $image = $request->file('cover');
        // //$buku = app('firebase.firestore')->database()->collection('buku')->document($uid);
        // $firebase_storage_path = 'cover/';
        // $name = $uid;
        // $localfolder = public_path('firebase-temp-uplouds') . '/';
        // $extension = $image->getClientOriginalExtension();
        // $file = $name . '.'. $extension;
        // if($image->move($localfolder, $file)){
        //     $uploadedfile = fopen($localfolder.$file, 'r');
        //     app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $firebase_storage_path . $file]);
        //     //menghapus dari local
        //     unlink($localfolder . $file);
            
        // }else{
        //     echo 'error';
        //}

        //cara realtime database youtube naufal
        // $ref = $this->database->getReference('buku/buku1')
        //     ->set([
        //         "buku2" => [
        //             'judul' => 'Pergi',
        //             'penulis' => 'Tere Liye'
        //         ]
        //         ]);
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
        return view('dashboard.pages.books.edit',[
            'oldData' => app('firebase.firestore')->database()->collection('books')->document($id)->snapshot()
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
            'cover' => 'required',
            'judul' => 'required',
            'tahun' => 'required',
            'stok' => 'required',
            'pengarang' => 'required',
            'sinopsis' => 'required',
        ]);
        try{
            app('firebase.firestore')->database()->collection('books')->document($id)->update([
                [ 'path' => 'cover' , 'value' => $request['cover'] ],
                [ 'path' => 'judul' , 'value' => $request['judul'] ],
                [ 'path' => 'pengarang' , 'value' => $request['pengarang'] ],
                [ 'path' => 'tahun_terbit' , 'value' => $request['tahun'] ],
                [ 'path' => 'stok' , 'value' => $request['stok'] ],
                [ 'path' => 'sinopsis' , 'value' => $request['sinopsis'] ],
            ]); 

            return redirect('/books')->with('success',"Book Has been Edited");
        } catch(\Exception $e){
            return redirect()->back()
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
        app('firebase.firestore')->database()->collection('books')->document($id)->delete();  
        return redirect('/books')->with('success',"Book Has been deleted");
    }
}
