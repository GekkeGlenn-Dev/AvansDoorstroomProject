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
    private ProductCategoryService $productCategoryService;

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

    public function __construct(ProductCategoryService $productCategoryService)
    {
        $this->productCategoryService = $productCategoryService;
    }

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
        $productCategories = $this->productCategoryService->all();

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
}
