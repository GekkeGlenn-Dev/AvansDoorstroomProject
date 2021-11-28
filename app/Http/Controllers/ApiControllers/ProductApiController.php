<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $sortOptions = $request->get('sortOptions', $this->shopService->getProductSorting());

        for ($i = 0; $i < count($sortOptions); $i++) {
            $sortOptions[$i]['active'] = filter_var($sortOptions[$i]['active'], FILTER_VALIDATE_BOOLEAN);
            $sortOptions[$i]['id'] = intval($sortOptions[$i]['id']);
        }

        // give query with response!

        $orderBy = $this->shopService->getProductOrderBy($sortOptions);

        // query to database and make a pagination.
        $products = Product::query()
            ->with('categories')
            ->orderBy($orderBy['key'], $orderBy['by'])
            ->paginate(3 * 8);

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
