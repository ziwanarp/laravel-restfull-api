<?php

namespace App\Services;

use App\Models\Addresses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressService {
    public function getAll(){
        // get all address
        $address = Addresses::all();

        // condition if address 0 or !0
        if(count($address) != 0){
            return response()->json([
                'status' => 200,
                'message' =>'success',
                'data' => $address,
            ],200);
        } else {
            return response()->json([
                'status' => 200,
                'message'=>'no data available',
                'data' => $address,
            ],200);
        }
    }

    public function addAddress(Request $request){
        // set rules
        $rules = [
            'customer_id' => 'required|integer',
            'address' => 'required|max:255',
            'district' => 'required|max:255',
            'city' => 'required|max:255',
            'province' => 'required|max:255',
            'postal_code' => 'required|integer'
        ];

        // Set validation
        $validator = Validator::make($request->all(), $rules);

        // if validate error return 422
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->messages()->first()
            ],422);
       }

        //insert data
        $address = Addresses::create($request->all());

        // return json response 201
        return response()->json([
            'status' => 201,
            'message' => 'data created',
            'data' => $address
        ],201);
    }

    public function getAddress($address){
        // find address by id
        $addresses = Addresses::find($address);
        
        // condition if address 0 or !0
        if($addresses != null){
            return response()->json([
                'status'=> 200,
                'message' => 'success',
                'data' => $addresses,
            ],200);
        } else {
            return response()->json([
                'status'=> 200,
                'message' => 'no data available',
                'data' => $addresses,
            ],200);
        }
    }

    public function updateAddress(Request $request, $address){
        // find address by id
        $addresses = Addresses::find($address);

        if($addresses != null){
            // set rules validation
            $rules = [
                'customer_id' => 'required|integer',
                'address' => 'required|max:255',
                'district' => 'required|max:255',
                'city' => 'required|max:255',
                'province' => 'required|max:255',
                'postal_code' => 'required|integer'
            ];
            // set validation
            $validator = Validator::make($request->all(), $rules);

            // if validate error return 422
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages()->first()
                ],422);
            }
            // set data for update
            $addresses->customer_id = $request->customer_id;
            $addresses->address = $request->address;
            $addresses->district = $request->district;
            $addresses->city = $request->city;
            $addresses->province = $request->province;
            $addresses->postal_code = $request->postal_code;
            $addresses->save();

            return response()->json([
                'status' => 200,
                'message' => 'data updated',
                'data' => $addresses,
            ],200);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'update failed',
                'data' => $addresses,
            ],200);

        }
    }

    public function deleteAddress($address){
         // find address and delete by id
         $deleted = Addresses::destroy($address);

         if($deleted != 0){
             return response()->json([
                 'status' => 200,
                 'message' => 'success deleted',
             ],200);
         } else {
             return response()->json([
                 'status' => 200,
                 'message' => 'delete failed',
             ],200);
 
         }
    }
}