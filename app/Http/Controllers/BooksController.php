<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');
        $user_id = $request->user_id;

        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            if ($user_id === '' || $user_id === null) {
                $books = Book::OrderBy("id", "DESC")->paginate(10);
            } else {
                $books = Book::Where("user_id", $user_id)->OrderBy("id", "DESC")->paginate(10);
            }

            if ($acceptHeader === 'application/json') {
                return response()->json($books->items('data'), 200);
            } else {
                $xml = new \SimpleXMLElement('<books/>');
                foreach ($books->items('data') as $item) {
                    $xmlItem = $xml->addChild('book');
                    $xmlItem->addChild('id', $item->id);
                    $xmlItem->addChild('shop_id', $item->shop_id);
                    $xmlItem->addChild('judul', $item->judul);
                    $xmlItem->addChild('pengarang', $item->pengarang);
                    $xmlItem->addChild('penerbit', $item->penerbit);
                    $xmlItem->addChild('genre', $item->genre);
                    $xmlItem->addChild('deskripsi', $item->deskripsi);
                    $xmlItem->addChild('tahun_terbit', $item->tahun_terbit);
                    $xmlItem->addChild('stok', $item->stok);
                    $xmlItem->addChild('harga', $item->harga);
                    $xmlItem->addChild('created_at', $item->created_at);
                    $xmlItem->addChild('updated_at', $item->updated_at);
                }
                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request    $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $acceptHeader = $request->header('Accept');
        
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {

            $input = $request->all();
            $book = Book::create($input);

            if ($acceptHeader === 'application/json') {
                return response()->json($book, 200);
            } else {
                $xml = new \SimpleXMLElement('<books/>');
                $xml->addChild('id', $book->id);
                $xml->addChild('shop_id', $book->shop_id);
                $xml->addChild('judul', $book->judul);
                $xml->addChild('pengarang', $book->pengarang);
                $xml->addChild('penerbit', $book->penerbit);
                $xml->addChild('genre', $book->genre);
                $xml->addChild('deskripsi', $book->deskripsi);
                $xml->addChild('tahun_terbit', $book->tahun_terbit);
                $xml->addChild('stok', $book->stok);
                $xml->addChild('harga', $book->harga);
                $xml->addChild('created_at', $book->created_at);
                $xml->addChild('updated_at', $book->updated_at);
                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }


    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function show(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');
        
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $book = Book::find($id);

            if (!$book) {
                abort(404);
            }
        
            if ($acceptHeader === 'application/json') {
                return response()->json($book, 200);
            } else {
                $xml = new \SimpleXMLElement('<books/>');
                $xml->addChild('id', $book->id);
                $xml->addChild('shop_id', $book->shop_id);
                $xml->addChild('judul', $book->judul);
                $xml->addChild('pengarang', $book->pengarang);
                $xml->addChild('penerbit', $book->penerbit);
                $xml->addChild('genre', $book->genre);
                $xml->addChild('deskripsi', $book->deskripsi);
                $xml->addChild('tahun_terbit', $book->tahun_terbit);
                $xml->addChild('stok', $book->stok);
                $xml->addChild('harga', $book->harga);
                $xml->addChild('created_at', $book->created_at);
                $xml->addChild('updated_at', $book->updated_at);
                return $xml->asXML();
            }
            
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    /**
    * Update the specified resource in storege
    *
    * @param \Illuminate\Http\Request   $request
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');
        
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $input = $request->all();

            $book = Book::find($id);

            if (!$book) {
                abort(404);
            }

            $book->fill($input);
            $book->save();

            if ($acceptHeader === 'application/json') {
                return response()->json($book, 200);
            } else {
                $xml = new \SimpleXMLElement('<books/>');
                $xml->addChild('id', $book->id);
                $xml->addChild('shop_id', $book->shop_id);
                $xml->addChild('judul', $book->judul);
                $xml->addChild('pengarang', $book->pengarang);
                $xml->addChild('penerbit', $book->penerbit);
                $xml->addChild('genre', $book->genre);
                $xml->addChild('deskripsi', $book->deskripsi);
                $xml->addChild('tahun_terbit', $book->tahun_terbit);
                $xml->addChild('stok', $book->stok);
                $xml->addChild('harga', $book->harga);
                $xml->addChild('created_at', $book->created_at);
                $xml->addChild('updated_at', $book->updated_at);
                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable!', 406);
        } 
    }

    /**
    * Remove the specified reaource from storage
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request, $id)
    {
        $acceptHeader = $request->header('Accept');
        
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml') {
            $book = Book::find($id);

            if (!$book) {
                abort(404);
            }

            $book->delete();

            if ($acceptHeader === 'application/json') {
                $message = ['message' => 'deleted successfully', 'book_id' => $id];
                return response()->json($message, 200);
            } else {
                $xml = new \SimpleXMLElement('<res/>');
                $xml->addChild('message', 'deleted successfully');
                $xml->addChild('id', $id);
                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable!', 406);
        }
        
    }

}

?>