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
        'active' => false,
    ];
    private const SORT_OPTION_LATEST_FIRST = [
        'id' => 2,
        'label' => 'Oudste eerst',
        'active' => false,
    ];
    private const SORT_OPTION_PRICE_LOW_TO_HIGH = [
        'id' => 3,
        'label' => 'Prijs: laag naar hoog',
        'active' => false,
    ];
    private const SORT_OPTION_PRICE_HIGH_TO_LOW = [
        'id' => 4,
        'label' => 'Prijs: hoog naar laag',
        'active' => false,
    ];

    private const SORT_OPTIONS = [
        self::SORT_OPTION_NEWEST_FIRST,
        self::SORT_OPTION_LATEST_FIRST,
        self::SORT_OPTION_PRICE_LOW_TO_HIGH,
        self::SORT_OPTION_PRICE_HIGH_TO_LOW,
    ];

    /**
     * TODAY 27-11-2021
     */
    public function getProductSorting(int $sortId = self::SORT_OPTION_NEWEST_FIRST['id']): array
    {
        $sorts = [];
        foreach (self::SORT_OPTIONS as $sort) {
            if ($sort['id'] === $sortId) {
                $sort['active'] = true;
            }
            $sorts[] = $sort;
        }
        return $sorts;
    }

    public function getProductOrderBy(array $sortOptions): array
    {
        $order = [
            'key' => 'id',
            'by' => 'desc'
        ];

        foreach ($sortOptions as $sort) {
            if (!$sort['active']) {
                continue;
            }

            switch ($sort['id']) {
                case self::SORT_OPTION_LATEST_FIRST['id']:
                    $order['key'] = 'id';
                    $order['by'] = 'asc';
                    break;

                case self::SORT_OPTION_PRICE_LOW_TO_HIGH['id']:
                    $order['key'] = 'price';
                    $order['by'] = 'asc';
                    break;

                case self::SORT_OPTION_PRICE_HIGH_TO_LOW['id']:
                    $order['key'] = 'price';
                    $order['by'] = 'desc';
                    break;

                case self::SORT_OPTION_NEWEST_FIRST['id']:
                default:
                    break;
            }
        }

        return $order;
    }

    public function getShopFilters(): array
    {
        $productCategories = Cache::remember('product.category.all', 60 * 60 * 24, function () {
            return ProductCategory::all();
        });

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

    // OLD

    /** This works */
    public function getCurrentProductSortingFromSortId(int $sortId = null): array
    {
        if ($sortId !== null) {
            $active = null;
            foreach (self::SORT_OPTIONS as $sort) {
                if ($sort['id'] === $sortId) {
                    $sort['active'] = true;
                    $active = $sort;
                } else {
                    $sort['active'] = false;
                }
            }
            return $active;
        }

        $item = self::SORT_OPTION_NEWEST_FIRST;
        $item['active'] = true;
        return $item;
    }

    public function getCurrentProductSortingFromSorts(array $sorts = null): array
    {
        if ($sorts !== null) {
            $active = null;
            foreach ($sorts as $sort) {
                if ($sort['active']) {
                    $sort['active'] = true;
                    $active = $sort;
                } else {
                    $sort['active'] = false;
                }
            }
            return $active;
        }

        $item = self::SORT_OPTION_NEWEST_FIRST;
        $item['active'] = true;
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
                $sortOptions[2]['active'] = true;
                break;

            case self::SORT_OPTION_PRICE_HIGH_TO_LOW['id']:
                $sortOptions[3]['active'] = true;
                break;

            case self::SORT_OPTION_LATEST_FIRST['id']:
                $sortOptions[1]['active'] = true;
                break;

            case self::SORT_OPTION_NEWEST_FIRST['id']:
            default:
                $sortOptions[0]['active'] = true;
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

    public function getQuery(): array
    {
        $categories = Cache::remember('product.category.all', 60 * 60 * 24, function () {
            return ProductCategory::all();
        });

        return [
            'sorts' => $this->getProductSortingArray(),
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
