<?php

namespace App\Http\Controllers\PublicController;

use App\Models\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::with('user')->OrderBy("id", "DESC")->paginate(5)->toArray();
        $response = [
            "total_count" => $books["total"],
            "limit" => $books["per_page"],
            "pagination" => [
                "next_page" => $books["next_page_url"],
                "current_page" => $books["current_page"]
            ],
            "data" => $books["data"],
        ];

        return response()->json($response, 200);
    }


    /**
    * Display the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $book = Book::with(['user' => function($query) {

            $query->select('id', 'name');
        }])->find($id);

        if(!$book) {
            abort(404);
        }

        return response()->json($book, 200);
    }


}

?>