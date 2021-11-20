<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

class BookPostController extends Controller
{
    protected $auth, $database;

    public function __construct()
    {
        // $factory = (new Factory)
        // ->withServiceAccount(__DIR__.'\config_Firebase.json')
        // ->withDatabaseUri('https://mars-library-26ce6-default-rtdb.asia-southeast1.firebasedatabase.app/');

        // $this->auth = $factory->createAuth();
        // $this->database = $factory->createDatabase(); 

        //cara dokumentasi
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.pages.books.index');
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
        // $validatedData = $request->validate([
        //     'judul' => 'required',
        //     'tahun' => 'required',
        //     'stok' => 'required',
        //     'pengarang' => 'required',
        //     'genre' => 'required',
        //     'sinopsis' => 'required',
        //     'cover' => 'image|file|max:1000',
        // ]);
        //cara web tutorial firestore
        // $stuRef = $this->database()->collection('buku')->newDocument();
        // $stuRef->set([
        //     'judul' => 'Pulang',
        //     'penulis' => "Tere Liye"
        // ]);
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
        //
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
}
