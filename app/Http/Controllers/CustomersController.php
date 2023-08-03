<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
    
    public function index()
    {
        // get all customers
        $customer = Customers::all();

        // condition if customers 0 or !0
        if(count($customer) != 0){
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' =>'success',
                'dataCount' => count($customer),
                'dataName' => 'Customers',
                'data' => $customer,
            ],200);
        } else {
            return response()->json([
                'status' => true,
                'code' => 200,
                'message'=>'success',
                'dataCount' => count($customer),
                'dataName' => 'Customers',
                'data' => 'no data available',
            ],200);
        }
    }


    public function store(Request $request)
    {
        // Set mimes validation
        $validator = Validator::make($request->all(), [
            'title' => 'required|in:Mr,Mrs',
            'name' => 'required|max:255',
            'gender' => 'required|in:M,F',
            'phone_number' => 'required|min:10|max:13|unique:customers',
            'image' => 'required|max:255',
            'email' => 'required|email:dns|unique:customers|max:255'
        ]);

        // if validate error return 422
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'code' => 422,
                'message' => $validator->messages()->first()
            ],422);
       }

        //insert data
        $customer = Customers::create($request->all());

        // return json response 201
        return response()->json([
            'status' => true,
            'code' => 201,
            'message' => 'success',
            'data' => $customer
        ],201);
        
    }


    public function show($customer)
    {
        // find customer by id
        $customers = Customers::find($customer);
        
        // condition if customer 0 or !0
        if($customers != null){
            return response()->json([
                'status'=> true,
                'code' => 200,
                'message' => 'success',
                'data' => $customers,
            ],200);
        } else {
            return response()->json([
                'status'=> false,
                'code' => 200,
                'message' => 'success',
                'data' => "data not found",
            ],200);
        }
        
    }


    public function update(Request $request, $customer)
    {
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
                $rules['email'] = 'required|email:dns|unique:customers|max:255';
            }

            if ($request->phone_number != $customers->phone_number) {
                $rules['phone_number'] = 'required|min:10|max:13|unique:customers';
            }

            $validator = Validator::make($request->all(), $rules);

            // if validate error return 422
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'code' => 422,
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
                'status' => true,
                'code' => 200,
                'message' => 'success',
                'data' => $customers,
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'failed',
                'data' => 'customer id not found',
            ],200);

        }

        
    }


    public function destroy($customer)
    {
        // delete semua post jika user_id dihapus
        // DB::table('posts')->where('user_id', '=', $user->id)->delete();

        // delete customer by id
        $deleted = Customers::destroy($customer);

        if($deleted != 0){
            return response()->json([
                'status' => true,
                'code' => 200,
                'message' => 'success',
            ],200);
        } else {
            return response()->json([
                'status' => false,
                'code' => 200,
                'message' => 'failed',
            ],200);

        }

    }
}
