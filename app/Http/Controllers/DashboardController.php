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
        // $user = app('firebase.firestore')->database()->collection('users')->document('PP8agvhioiSn29Eb6DEgsHkrr7q1')->snapshot();
        // dd($user->data()['username']);
        $list = [];
        $temp = app('firebase.firestore')->database()->collection('pinjambuku')->documents();
        foreach ($temp as &$data) {
            $id_buku = $data->data()['book_id'];
            $id_user = $data->data()['user_id'];
            
            $user = app('firebase.firestore')->database()->collection('users')->document($id_user)->snapshot();
            $buku = app('firebase.firestore')->database()->collection('books')->document($id_buku)->snapshot();

            $username = $user->data()['username'];
            $email = $user->data()['email'];
            $judul = $buku->data()['judul'];
            $pengarang = $buku->data()['pengarang'];

            $object = new stdClass();
            $object->username = $username;
            $object->email = $email;
            $object->judul = $judul;
            $object->pengarang = $pengarang;

            array_push($list, $object);
        }
        return view('dashboard.pages.index',[
            'user' => app('firebase.firestore')->database()->collection('users')->documents()->size(),
            'book' => app('firebase.firestore')->database()->collection('books')->documents()->size(),
            'pinjam' => app('firebase.firestore')->database()->collection('pinjambuku')->documents()->size(),
            'data_pinjam' => $list
        ]);
    }
}
