<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {
            $transactions = Transaction::OrderBy("id", "DESC")->paginate(5)->toArray();

            if ($acceptHeader === 'application/json') {
                $response = [
                    "total_count" => $transactions["total"],
                    "limit" => $transactions["per_page"],
                    "pagination" => [
                        "next_page" => $transactions["next_page_url"],
                        "current_page" => $transactions["current_page"]
                    ],
                    "data" => $transactions["data"],
                ];
                return response()->json($response, 200);
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

        // validasi: hanya application/json atau aaplication/xml yang valid
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
            $transaction = Transaction::find($id);

            if(!$transaction){
                abort(404);
            }

            return response()->json($transaction, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }

}

?>