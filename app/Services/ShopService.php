<?php


namespace App\Services;


use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class ShopService
{
    public const FILTER_CATEGORY = 'category';

    private const SORT_OPTION_NEWEST_FIRST = [
        'id' => 1,
        'label' => 'Nieuwste eerst',
        'current' => false,
    ];
    private const SORT_OPTION_LATEST_FIRST = [
        'id' => 2,
        'label' => 'Oudste eerst',
        'current' => false,
    ];
    private const SORT_OPTION_PRICE_LOW_TO_HIGH = [
        'id' => 3,
        'label' => 'Prijs: laag naar hoog',
        'current' => false,
    ];
    private const SORT_OPTION_PRICE_HIGH_TO_LOW = [
        'id' => 4,
        'label' => 'Prijs: hoog naar laag',
        'current' => false,
    ];

    private const SORT_OPTIONS = [
        self::SORT_OPTION_NEWEST_FIRST,
        self::SORT_OPTION_LATEST_FIRST,
        self::SORT_OPTION_PRICE_LOW_TO_HIGH,
        self::SORT_OPTION_PRICE_HIGH_TO_LOW,
    ];

    /** This works */
    public function getCurrentProductSortingFromSortId(int $sortId = null): array
    {
        if ($sortId !== null) {
            $current = null;
            foreach (self::SORT_OPTIONS as $sort) {
                if ($sort['id'] === $sortId) {
                    $sort['current'] = true;
                    $current = $sort;
                } else {
                    $sort['current'] = false;
                }
            }
            return $current;
        }

        $item = self::SORT_OPTION_NEWEST_FIRST;
        $item['current'] = true;
        return $item;
    }

    public function getCurrentProductSortingFromSorts(array $sorts = null): array
    {
        if ($sorts !== null) {
            $current = null;
            foreach ($sorts as $sort) {
                if ($sort['current']) {
                    $sort['current'] = true;
                    $current = $sort;
                } else {
                    $sort['current'] = false;
                }
            }
            return $current;
        }

        $item = self::SORT_OPTION_NEWEST_FIRST;
        $item['current'] = true;
        return $item;
    }

    /** This works */
    public function getProductSortingArray(int $sort = null): array
    {
        if ($sort === null) {
            $sort = self::SORT_OPTION_NEWEST_FIRST['id'];
        }

        $sortOptions = self::SORT_OPTIONS;
        switch ($sort) {
            case self::SORT_OPTION_PRICE_LOW_TO_HIGH['id']:
                $sortOptions[2]['current'] = true;
                break;

            case self::SORT_OPTION_PRICE_HIGH_TO_LOW['id']:
                $sortOptions[3]['current'] = true;
                break;

            case self::SORT_OPTION_LATEST_FIRST['id']:
                $sortOptions[1]['current'] = true;
                break;

            case self::SORT_OPTION_NEWEST_FIRST['id']:
            default:
                $sortOptions[0]['current'] = true;
                break;
        }
        return $sortOptions;
    }

    /** This works */
    public function getProductSortQuery(int $sort = null): array
    {
        if ($sort === null) {
            $sort = self::SORT_OPTION_NEWEST_FIRST['id'];
        }
        switch ($sort) {
            case self::SORT_OPTION_PRICE_LOW_TO_HIGH['id']:
                $sort = [
                    'column' => 'price',
                    'direction' => 'asc'
                ];

                break;

            case self::SORT_OPTION_PRICE_HIGH_TO_LOW['id']:
                $sort = [
                    'column' => 'price',
                    'direction' => 'desc'
                ];
                break;

            case self::SORT_OPTION_LATEST_FIRST['id']:
                $sort = [
                    'column' => 'created_at',
                    'direction' => 'asc'
                ];
                break;

            case self::SORT_OPTION_NEWEST_FIRST['id']:
            default:
                $sort = [
                    'column' => 'created_at',
                    'direction' => 'desc'
                ];
                break;
        }
        return $sort;
    }

    public function getShopFilters(array $productCategories): array
    {
        $filters = [];
        $categoryFilter = [
            'id' => self::FILTER_CATEGORY,
            'name' => 'Categorieën',
            'options' => []
        ];

        foreach ($productCategories as $category) {
            array_push($categoryFilter['options'], [
                'value' => $category['id'],
                'label' => $category['name'],
                'checked' => false
            ]);
        }

        array_push($filters, $categoryFilter);

        return $filters;
    }

    public function getQuery(): array
    {
        $categories = Cache::remember('product.category.all', 60 * 60 * 24, function () {
            return ProductCategory::all();
        });

        return [
            'sorts' =>  $this->getProductSortingArray(),
            'filters' => $this->getShopFilters($categories->toArray()),
        ];
    }

    public function executeProductQuery(array $query, bool $toJson = false)
    {
        $sorts = $query['sorts'];
        $currentSort = $this->getCurrentProductSortingFromSorts($sorts);
        return json_encode($query);

        $filters = $query['filters'];
        $filterIsSelected = false;
        $filterIds = [];

        foreach ($filters as $section) {
            foreach ($section['options'] as $option) {
                if ($option['checked']) {
                    array_push($filterIds, $option['value']);
                    $filterIsSelected = true;
                }
            }
        }

        if ($filterIsSelected) {
            $products = $this->getProductsBySortAndFilters($currentSort, $filterIds);
        } else {
            $products = $this->getProductsBySort($currentSort);
        }

        if ($toJson) {
            return $products->toJson();
        }
        return $products;
    }

    private function getProductsBySort(array $sort): LengthAwarePaginator
    {
        $sortQuery = $this->getProductSortQuery($sort['id']);

        return Product::with('categories', 'images')
            ->orderBy($sortQuery['column'], $sortQuery['direction'])
            ->paginate(21);
    }

    private function getProductsBySortAndFilters(array $sort, array $ids): LengthAwarePaginator
    {
        $sortQuery = $this->getProductSortQuery($sort['id']);

        return Product::with('categories', 'images')
            ->whereHas('categories', function (Builder $query) use ($ids) {
                $query->whereIn('product_categories.id', $ids);
            })
            ->orderBy($sortQuery['column'], $sortQuery['direction'])
            ->paginate(21);
    }
}
