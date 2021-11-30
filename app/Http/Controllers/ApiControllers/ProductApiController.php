<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ShopService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    private array $categoriesNotSelected = [];
    private array $categoriesSelected = [];

    public function index(Request $request): JsonResponse
    {
        $sortOptions = $request->get('sortOptions', $this->shopService->getProductSorting());
        $filters = $request->get('filters', $this->shopService->getShopFilters());

        for ($i = 0; $i < count($sortOptions); $i++) {
            $sortOptions[$i]['active'] = filter_var($sortOptions[$i]['active'], FILTER_VALIDATE_BOOLEAN);
            $sortOptions[$i]['id'] = intval($sortOptions[$i]['id']);
        }

        foreach ($filters as $filterSection) {
            $this->filters($filterSection);
        }

        // give query with response!

        $orderBy = $this->shopService->getProductOrderBy($sortOptions);

        // query to database and make a pagination.
        $products = Product::query()
            ->with('categories')
            ->whereHas('categories', function (Builder $query) {
                $query->whereIn('product_categories.id', $this->getCategoryIds());
            })
            ->orderBy($orderBy['key'], $orderBy['by'])
            ->paginate(3 * 8);

        return response()->json($products);
    }

    private function filters(array $section): void
    {
        switch ($section['id']) {
            case ShopService::FILTER_CATEGORY:
                $this->categoryFilter($section['options']);
                break;
            default:
                break;
        }
    }

    private function categoryFilter(array $options)
    {
        foreach ($options as $option) {
            if ($option['checked']) {
                $this->categoriesSelected[] = $option;
            } else {
                $this->categoriesNotSelected[] = $option;
            }
        }
    }

    private function getCategoryIds(): array
    {
        $ids = [];
        $selectedArray = count($this->categoriesSelected) > 0
            ? $this->categoriesSelected
            : $this->categoriesNotSelected;

        foreach ($selectedArray as $cat) {
            $ids[] = $cat['value'];
        }
        return $ids;
    }
}
