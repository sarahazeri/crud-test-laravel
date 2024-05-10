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
/**
 * @OA\Info(title="My First API", version="0.1")
 * @OA\Tag(
 *     name="Customers",
 *     description="API Endpoints for Customers"
 * )
 */
class ApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/customers",
     *     tags={"Customers"},
     *     summary="Get all customers",
     *     description="Returns a list of all customers.",
     *     @OA\Response(response="200", description="Successful operation"),
     *     security={}
     * )
     */
    public function index(): JsonResponse
    {
        $customerQueryRepository = new CustomerQueryRepository();
        $customers = $customerQueryRepository->getAll();
        return response()->json($customers, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/customers",
     *     tags={"Customers"},
     *     summary="Create a new customer",
     *     description="Creates a new customer.",
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(response="201", description="Customer created successfully"),
     *     @OA\Response(response="400", description="Bad request")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/api/customers/{id}",
     *     tags={"Customers"},
     *     summary="Update a customer",
     *     description="Updates an existing customer by ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the customer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="Customer updated successfully"),
     *     @OA\Response(response="400", description="Bad request"),
     *     @OA\Response(response="404", description="Customer not found")
     * )
     */
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

    /**
     * @OA\Delete(
     *     path="/api/customers/{id}",
     *     tags={"Customers"},
     *     summary="Delete a customer",
     *     description="Deletes an existing customer by ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the customer",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="204", description="Customer deleted successfully"),
     *     @OA\Response(response="404", description="Customer not found")
     * )
     */
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
