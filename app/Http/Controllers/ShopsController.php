<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopsController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {
            $shops = Shop::OrderBy("id", "DESC")->paginate(5)->toArray();

            if ($acceptHeader === 'application/json') {
                $response = [
                    "total_count" => $shops["total"],
                    "limit" => $shops["per_page"],
                    "pagination" => [
                        "next_page" => $shops["next_page_url"],
                        "current_page" => $shops["current_page"]
                    ],
                    "data" => $shops["data"],
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
                'nama_toko' => 'required|min:5',
                'alamat' => 'required|min:5',
            ];
    
            $validator = Validator::make($input, $validationRules);
    
            if($validator->fails()){
                return response()->json($validator->errors(), 400);
            }
    
            $shop = Shop::create($input);
            return response()->json($shop, 200);

            
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
            $shop = Shop::find($id);

            if(!$shop){
                abort(404);
            }

            return response()->json($shop, 200);
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
        $input = $request->all();

        $shop = Shop::find($id);

        if(!$shop){
            abort(404);
        }

        //validation
        $validationRules = [
            'nama_toko' => 'required|min:5',
            'alamat' => 'required|min:5',
        ];

        $validator = Validator::make($input, $validationRules);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        //validation end
        
        $shop->fill($input);
        $shop->save();
        
        return response()->json($shop, 200);
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
            $shop = Shop::find($id);

            if(!$shop){
                abort(404);
            }

            $shop->delete();
            $message = ['message' => 'deleted successfully', 'shop_id' => $id];

            return response()->json($message, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }

}

?>