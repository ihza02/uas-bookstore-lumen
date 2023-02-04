<?php

namespace App\Http\Controllers\PublicController;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {
            $transactions = Transaction::with('user')->OrderBy("id", "DESC")->paginate(5)->toArray();

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
            $validationRules = [
                'user_id' => 'required|min:1',
                'book_id' => 'required|min:1',
                'total_harga' => 'required|min:5',
            ];
    
            $validator = Validator::make($input, $validationRules);
    
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }
    
            $Transaction = Transaction::create($input);
            return response()->json($Transaction, 200);

            
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
            $transaction = Transaction::with(['user' => function($query) {

                $query->select('id', 'name');
            }])->find($id);

            if(!$transaction){
                abort(404);
            }

            return response()->json($transaction, 200);
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

            $transaction = Transaction::find($id);

            if (!$transaction) {
                abort(404);
            }
             //validation
            $validationRules = [
                'user_id' => 'required|min:1',
                'book_id' => 'required|min:1',
                'total_harga' => 'required|min:5',
            ];

            $validator = Validator::make($input, $validationRules);

            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }

            $transaction->fill($input);
            $transaction->save();

            return response()->json($transaction, 200);
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

        // validasi: hanya application/json atau aaplication/xml yang valid
        if ($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
            $transaction = Transaction::find($id);

            if(!$transaction){
                abort(404);
            }

            $transaction->delete();
            $message = ['message' => 'deleted successfully', 'transaction_id' => $id];

            return response()->json($message, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }

}

?>