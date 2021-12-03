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
        $list_tanggal = [];
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
                    
                    array_push($list_tanggal, $tanggal);
                    array_push($list, $object);
                }
            }
        }
        
        return view('dashboard.pages.index',[
            'user' => app('firebase.firestore')->database()->collection('users')->documents()->size(),
            'book' => app('firebase.firestore')->database()->collection('books')->documents()->size(),
            'pinjam' => sizeof($list),
            'data_pinjam' => $list,
            'tgl_pinjam' => $list_tanggal
        ]);
    }

    public function show(Request $request){
        $id_buku = $request['buku'];
        $id_user = $request['user'];
        try{
            app('firebase.firestore')->database()->collection('users')->document($id_user)->collection('cart')->document($id_buku)->delete();
            try{
                $oldBuku = app('firebase.firestore')->database()->collection('books')->document($id_buku)->snapshot();
                $newStok = intval( $oldBuku->data()['stok']) + 1;                
                app('firebase.firestore')->database()->collection('books')->document($id_buku)->update([
                    [ 'path' => 'stok' , 'value' => strval($newStok) ]
                ]); 
            } catch(\Exception $e){
                echo $e->getMessage();
            }
            return redirect('/dashboard')->with('success',"Book Has been Returned");
        } catch(\Exception $e){
            echo $e->getMessage();
        }
    }
}
