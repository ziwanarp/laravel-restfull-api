<?php

namespace App\Services;

use App\Models\Addresses;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerService {

    public function getAll (){
        // get all customers
        $customer = Customers::all();

        // condition if customers 0 or !0
        if(count($customer) != 0){
            return response()->json([
                'status' => 200,
                'message' =>'success',
                'data' => $customer,
            ],200);
        }

        return response()->json([
            'status' => 200,
            'message'=>'no data available',
            'data' => $customer,
        ],200);
        
    }

    public function addCustomer(Request $request){
         // set rules
         $rules = [
            'title' => 'required|in:Mr,Mrs',
            'name' => 'required|max:255',
            'gender' => 'required|in:M,F',
            'phone_number' => 'required|min:10|max:13|unique:customers',
            'image' => 'required|max:255',
            'email' => 'required|email|unique:customers|max:255'
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
        $customer = Customers::create($request->all());

        // return json response 201
        return response()->json([
            'status' => 201,
            'message' => 'data created',
            'data' => $customer
        ],201);
        
    }

    public function getCustomer($customer){
        // find customer by id
        $customers = Customers::find($customer);
        $addresses = Addresses::where('customer_id', $customer)->get();
        
        // condition if customer 0 or !0
        if($customers != null){
            $customers['address'] = $addresses;

            return response()->json([
                'status'=> 200,
                'message' => 'success',
                'data' => $customers,
            ],200);
        } else {
            return response()->json([
                'status'=> 200,
                'message' => 'no data available',
                'data' => $customers,
            ],200);
        }
    }

    public function updateCustomer (Request $request, $customer){
        $customers = Customers::find($customer);

        if($customers != null){
            // set rules validation
            $rules = [
                'title' => 'required|in:Mr,Mrs',
                'name' => 'required|max:255',
                'gender' => 'required|in:M,F',
                'image' => 'required|max:255',
            ];

            if ($request->email != $customers->email) {
                $rules['email'] = 'required|email|unique:customers|max:255';
            }

            if ($request->phone_number != $customers->phone_number) {
                $rules['phone_number'] = 'required|min:10|max:13|unique:customers';
            }

            $validator = Validator::make($request->all(), $rules);

            // if validate error return 422
            if ($validator->fails()) {
                return response()->json([
                    'status' => 422,
                    'message' => $validator->messages()->first()
                ],422);
            }

            // Customers::where('id', $customer)->update([$request->all()]);
            
            $customers->title = $request->title;
            $customers->name = $request->name;
            $customers->gender = $request->gender;
            $customers->phone_number = $request->phone_number;
            $customers->image = $request->image;
            $customers->email = $request->email;
            $customers->save();

            return response()->json([
                'status' => 200,
                'message' => 'data updated',
                'data' => $customers,
            ],200);
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'update failed',
                'data' => $customers,
            ],200);

        }
    }

    public function deleteCustomer($customer){

        // delete customer by id
        $deleted = Customers::destroy($customer);
        // delete address by customer_id
        Addresses::where('customer_id', $customer)->delete();

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