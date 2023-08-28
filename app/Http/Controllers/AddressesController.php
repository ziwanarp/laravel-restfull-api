<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AddressService;

class AddressesController extends Controller
{
    private $address;

    public function __construct()
    {
        $this->address = new AddressService;
    }
    
    public function index()
    {
         $this->address->getAll();
    }

    public function store(Request $request)
    {
        $this->address->addAddress($request);
    }

    public function show($address)
    {
        return $this->address->getAddress($address);
    }

    public function update(Request $request, $address)
    {
        return $this->address->updateAddress($request, $address);
    }

    public function destroy($address)
    {
       return $this->address->deleteAddress($address);
    }
}
