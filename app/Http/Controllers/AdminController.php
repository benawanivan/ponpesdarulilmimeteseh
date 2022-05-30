<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use App\Models\User;
use App\Models\Post;
use App\Models\Product;

class AdminController extends Controller
{
    public function adminlogin()
    {
        return view('admin/adminlogin');
    }

    public function proses_login(Request $request){
        // dd($request->all());
        $data = User::where('username', $request->username)->first();
        if($data){
            if(\Hash::check($request->password,$data->password)){
                session(['status' => 'login',
                        'username' => $request->username]);
                return redirect()->route('kelolaberita');
            }
            else {
                return redirect()->route('adminlogin')->with('message','Password Salah!');
            }
        }
        else{
            return redirect()->route('adminlogin')->with('message','Username tidak ditemukan!');
        }
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
    }

    public function kelolaberita()
    {
        $berita = DB::table('posts')->get();
        return view('admin/kelolaberita', ['berita' => $berita]);
    }

    public function tambahberita()
    {
        return view('admin/tambahberita');
    }

    public function kelolaproduk()
    {
        $product = DB::table('products')->get();
        return view('admin/kelolaproduk', ['product' => $product]);
    }

    public function tambahproduk()
    {
        return view('admin/tambahproduk');
    }

    public function proses_upload(Request $request){
		$this->validate($request, [
			'image' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
			'isi' => 'required',
			'judul' => 'required',
		]);
 
		// menyimpan data file yang diupload ke variabel $file
		$file = $request->file('image');
		$nama_file = time()."_".$file->getClientOriginalName();
 
        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'data_berita';
		$file->move($tujuan_upload,$nama_file);
 
		Post::create([
			'gambar' => $nama_file,
			'isi' => $request->isi,
			'judul' => $request->judul,
            'tgl_upload' => time(),
		]);
 
        return redirect()->route('kelolaberita')->with('success','Upload Berita Berhasil');
	}
    public function proses_upload2(Request $request){
		$this->validate($request, [
			'image' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
			'nama' => 'required',
			'harga' => 'required',
		]);
 
		// menyimpan data file yang diupload ke variabel $file
		$file = $request->file('image');
		$nama_file = time()."_".$file->getClientOriginalName();
 
        // isi dengan nama folder tempat kemana file diupload
		$tujuan_upload = 'data_produk';
		$file->move($tujuan_upload,$nama_file);
 
		Product::create([
			'gambar' => $nama_file,
			'nama' => $request->nama,
			'harga' => $request->harga,
		]);
 
        return redirect()->route('kelolaproduk')->with('success','Upload Produk Berhasil');
	}

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $image_path = public_path("data_berita/$post->gambar");

        if(File::exists($image_path)){
            File::delete($image_path);
        }

        DB::delete('delete from posts where id = ?',[$id]);
        return redirect('/kelolaberita')->with('success', 'Data berhasil dihapus!');
    }

    public function destroy2($id)
    {
        $post = Product::findOrFail($id);
        $image_path = public_path("data_produk/$post->gambar");

        if(File::exists($image_path)){
            File::delete($image_path);
        }

        DB::delete('delete from products where id = ?',[$id]);
        return redirect('/kelolaproduk')->with('success', 'Data berhasil dihapus!');
    }
}
