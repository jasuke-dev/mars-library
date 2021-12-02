<?php

namespace App\Http\Controllers;

use stdClass;
use Illuminate\Http\Request;
use Kreait\Firebase\Firestore;
use App\Http\Controllers\Controller;
use Google\Cloud\Firestore\FirestoreClient;

class DashboardController extends Controller
{
    public function index(){        
        $list = [];
        $temp = app('firebase.firestore')->database()->collection('users')->documents();
        foreach ($temp as &$data) {
            $id_user = $data->data()['id'];
            $username = $data->data()['username'];
            $email = $data->data()['email'];
            
            if(!$data->data()['isAdmin']){
                $books = app('firebase.firestore')->database()->collection('users')->document($id_user)->collection('cart')->documents();
                foreach($books as $buku){
        
                    $judul = $buku->data()['judul'];
                    $pengarang = $buku->data()['pengarang'];
                    $id_buku = $buku->data()['id'];
                    $tanggal = $buku->data()['tanggal'];
        
                    $object = new stdClass();
                    $object->id_buku = $id_buku;
                    $object->id_user = $id_user;
                    $object->username = $username;
                    $object->email = $email;
                    $object->judul = $judul;
                    $object->pengarang = $pengarang;
                    $object->tanggal = $tanggal;
        
                    array_push($list, $object);
                }
            }
        }
        return view('dashboard.pages.index',[
            'user' => app('firebase.firestore')->database()->collection('users')->documents()->size(),
            'book' => app('firebase.firestore')->database()->collection('books')->documents()->size(),
            'pinjam' => sizeof($list),
            'data_pinjam' => $list
        ]);
    }

    public function show(Post $user, Post $buku){

    }
}
