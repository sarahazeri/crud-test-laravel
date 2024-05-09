<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Entities\Customer;
use App\Models\Enums\CustomerPrefixPhoneNumberEnum;
use App\Models\Factories\CustomerFactory;
use App\Models\Repositories\Customer\Command\CustomerCommandRepository;
use App\Models\Repositories\Customer\Query\CustomerQueryRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $customerQueryRepository = new CustomerQueryRepository();
        $customers = $customerQueryRepository->getAll();
        return view('customers.index', [
            'customers' => $customers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request): RedirectResponse
    {
        $customerCommandRepository = new CustomerCommandRepository();
        $customerModel = (new CustomerFactory())->makeEntityFromArray($request->all());
        $customerCommandRepository->create($customerModel);
        return redirect()->route('customers.index')
            ->withSuccess('New Customer is added successfully.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('customers.create', ['prefixes' => CustomerPrefixPhoneNumberEnum::cases()]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): View
    {
        $customer = (new CustomerCommandRepository())->getOneById($id);
        return view('customers.show', [
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id): View
    {
        $customer = (new CustomerCommandRepository())->getOneById($id);
        return view('customers.edit', [
            'customer' => $customer, 'prefixes' => CustomerPrefixPhoneNumberEnum::cases()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, int $id): RedirectResponse
    {
        $customer = (new CustomerCommandRepository())->getOneById($id);
        $customerModel = (new CustomerFactory())->changeEntityFromArray($customer, $request->all());
        (new CustomerCommandRepository())->update($customerModel);
        return redirect()->back()
            ->withSuccess('Customer is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->withSuccess('Customer is deleted successfully.');
    }
}
