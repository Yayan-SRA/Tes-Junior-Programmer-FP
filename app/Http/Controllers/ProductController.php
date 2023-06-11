<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function generateData()
    {
    // Create a new Guzzle client instance
    $client = new Client();

    $currentDate = Carbon::now();
    $serverDateTime = Carbon::now();
    $timeNow = $currentDate->format('d-m-y');
    $serverDate = $serverDateTime->format('dmyCH');
    try {
        $apiUrl = 'https://recruitment.fastprint.co.id/tes/api_tes_programmer';
    
        $username = 'tesprogrammer' . $serverDate;
        $password = 'bisacoding-' . $timeNow;
        // hash password
        $hashedPassword = md5($password);
        $data = [
            'username' => $username,
            'password' => $hashedPassword,
        ];

            // Send a POST request to the API with the form parameters
        $response = $client->post($apiUrl, [
            'form_params' => $data,
        ]);

        $responseBody = (string) $response->getBody();
        $responseData = json_decode($responseBody, true); 

        $result = $responseData['data'];

        for ($i=0; $i < count($result); $i++) { 
            $product = new Product();
            // $product->no = $result[$i]['no'];
            $product->id_produk = $result[$i]['id_produk'];
            $product->nama_produk = $result[$i]['nama_produk'];
            $product->kategori = $result[$i]['kategori'];
            $product->harga = $result[$i]['harga'];
            $product->status = $result[$i]['status'];
            $product->save();
        }
        return redirect('/')->with('success', "Data berhasil didapatkan dan disimpan");

    }
    catch (Exception $e) {
        return view('welcome',[
            'results' => $e->getMessage()
        ]);
    }
    }

    public function index(){
        return view('index',[
            'title'=>'Tes Junior Programmer',
            'products'=> Product::orderByDesc('id_produk')->where('status','bisa dijual')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('formCreate',[
            'title'=>'Form Create',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_produk' => 'required|unique:products,nama_produk',
            'kategori' => 'required',
            'harga' => 'required|integer|min:0',
            'status' => 'required',
        ]);

        Product::create($validatedData);
        return redirect('/')->with('success', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_produk)
    {
        $product = Product::find($id_produk);
        return view('formEdit',[
            'title'=>'Form',
            'item'=>$product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_produk)
    {
        $product = Product::find($id_produk);
        $rules = ([
            'kategori' => 'required',
            'harga' => 'required|integer|min:0',
            'status' => 'required',
        ]);

        if($request->nama_produk !== $product->nama_produk){
            $rules['nama_produk'] = 'required|unique:products,nama_produk';
            
        }

        $validatedData = $request->validate($rules);

        $product->update($validatedData);
        return redirect('/')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_produk)
    {
        $product = Product::find($id_produk);
        $product->delete();
        return redirect()->route('home.index')->with('success', 'Produk berhasil dihapus');
        
    }
}
