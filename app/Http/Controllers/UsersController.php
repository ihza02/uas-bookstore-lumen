<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');

        if ($acceptHeader === 'application/json') {
            $users = User::OrderBy("id", "DESC")->paginate(5)->toArray();

            if ($acceptHeader === 'application/json') {
                $response = [
                    "total_count" => $users["total"],
                    "limit" => $users["per_page"],
                    "pagination" => [
                        "next_page" => $users["next_page_url"],
                        "current_page" => $users["current_page"]
                    ],
                    "data" => $users["data"],
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
            $user = User::find($id);

            if(!$user){
                abort(404);
            }

            return response()->json($user, 200);
        } else {
            return response('Not Acceptable!', 406);
        }
    }
}

?>