<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Entities\Customer;
use App\Models\Factories\CustomerFactory;
use App\Models\Repositories\Customer\Command\CustomerCommandRepository;
use App\Models\Repositories\Customer\Query\CustomerQueryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{

    public function index(): JsonResponse
    {
        $customerQueryRepository = new CustomerQueryRepository();
        $customers = $customerQueryRepository->getAll();
        return response()->json($customers, 200);
    }

    public function store(Request $request): JsonResponse
    {
        $customerCommandRepository = new CustomerCommandRepository();

        $validator = Validator::make($request->all(), (new CustomerRequest())->rules($request), [
            'first_name.unique' => 'The combination of first_name, last_name, and date_of_birth must be unique.',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $customerModel = (new CustomerFactory())->makeEntityFromArray($request->all());
        $customer = $customerCommandRepository->create($customerModel);
        return response()->json($customer, 201);
    }

    public function show($id): JsonResponse
    {
        $customerQueryRepository = new CustomerQueryRepository();
        $customer = $customerQueryRepository->getOneById($id);
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
        return response()->json($customer, 200);
    }

    public function update(Request $request, $id)
    {
        $customerCommandRepository = new CustomerCommandRepository();
        $validator = Validator::make($request->all(), (new CustomerRequest())->rules($request), [
            'first_name.unique' => 'The combination of first_name, last_name, and date_of_birth must be unique.',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $customer = $customerCommandRepository->getOneById($id);
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $customerModel = (new CustomerFactory())->changeEntityFromArray($customer, $request->all());
        $customer = $customerCommandRepository->update($customerModel);
        return response()->json($customer, 200);


    }

    public function destroy($id)
    {
        $customerCommandRepository = new CustomerCommandRepository();
        $customer = $customerCommandRepository->getOneById($id);
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
        $customerCommandRepository->delete($customer);
        return response()->json(null, 204);
    }
}
