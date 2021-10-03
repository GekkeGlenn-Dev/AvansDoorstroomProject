<?php


namespace App\Services;


use Illuminate\Support\Collection;

class DashboardService
{
    public function getChartSeries(array $period, Collection $orders): array
    {
        $orderSerie = [
            'name' => 'Bestellingen',
            'data'
        ];

        for ($i = 0; $i < count($period); $i++) {
            $orderSerie['data'][$i]['x'] = $period[$i]->format('d F');
            $orderSerie['data'][$i]['y'] = 0;
        }

        foreach ($orders as $order) {
            for ($i = 0; $i < count($period); $i++) {
                $orderDay = $order->created_at->startOfDay();
                $periodDay = $period[$i]->startOfDay();

                if ($orderDay->diffInDays($periodDay) === 0) {
                    $orderSerie['data'][$i]['y']++;
                }
            }
        }
        return $orderSerie;
    }

    public function generateRevenueAndSalesOverviewTotals($orders): Collection
    {
        $revenue = 0;
        $sales = 0;

        foreach ($orders as $order) {
            foreach ($order->products as $product) {
                $revenue += $product->price * $product->pivot->quantity;
                $sales += $product->pivot->quantity;
            }
        }

        return new Collection([
            'revenue' => $revenue,
            'sales' => $sales
        ]);
    }
}
