<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerService;

class CustomersController extends Controller
{
    private $customer;

    public function __construct()
    {
        $this->customer = new CustomerService;
    }

    public function index()
    {
        return $this->customer->getAll();
    }

    public function store(Request $request)
    {
       return $this->customer->addCustomer($request);
    }

    public function show($customer)
    {
        return $this->customer->getCustomer($customer);
    }

    public function update(Request $request, $customer)
    {
        return $this->customer->updateCustomer($request, $customer);
    }

    public function destroy($customer)
    {
        return $this->customer->deleteCustomer($customer);
    }
}
