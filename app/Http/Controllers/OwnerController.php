<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    private const ERROR_500_MESSAGE = 'An error occurred. Please try again later';
    private const USER_DOES_NOT_EXIST = 'Sorry this user does not exist';

    // add Owner
    public function addOwner(Request $request) {
        $owner = new Owner;
        $owner->name = $request->name;
        $owner->email = $request->email;
        $owner->password = $request->password;
        $owner->save();
        

        return $this->sendResponse($owner, "User successfully registered", "USER-REGISTERED", 201);
    }

    //get and return single Owner for frontend authentication
    public function GetSingleOwner(Request $request) {
        $owner = DB::table('owners')->where('name', $request->name)->first();
        if(is_null($owner)) {
            return $this->errorResponse($this::USER_DOES_NOT_EXIST, "ERR-UNAVAILABLE", 404);
        }

        return $this->sendResponse($owner, "User successfully registered", "USER-EXISTS", 201);
    }
}
