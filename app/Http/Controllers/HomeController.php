<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use App\Models\User;
use App\Models\Post;
use App\Models\Product;

class HomeController extends Controller
{
    public function home()
    {
        return view('index');
    }

    public function berita()
    {
        $berita = DB::table('posts')->get();
        return view('berita', ['berita' => $berita]);
    }
    
    public function detailberita($request)
    {
        $id = request('id');
        $berita = DB::table('posts')->where('id','=', $id)->first();
        return view('detailberita', ['berita' => $berita]);
    }

    public function ecommerce()
    {
        $product = DB::table('products')->get();
        return view('ecommerce', ['product' => $product]);
    }
}
