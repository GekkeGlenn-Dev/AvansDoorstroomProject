<?php


namespace App\Services;


class ShopService
{
    private const FILTER_CATEGORY = 'category';

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
}
