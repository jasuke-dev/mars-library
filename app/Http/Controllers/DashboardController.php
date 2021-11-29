<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Firestore;
use Google\Cloud\Firestore\FirestoreClient;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard.pages.index',[
            'user' => app('firebase.firestore')->database()->collection('users')->documents()->size(),
            'book' => app('firebase.firestore')->database()->collection('books')->documents()->size(),
            'pinjam' => app('firebase.firestore')->database()->collection('pinjambuku')->documents()->size()
        ]);
    }
}
