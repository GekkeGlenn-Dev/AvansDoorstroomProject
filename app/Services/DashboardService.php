<?php


namespace App\Services;


use Illuminate\Support\Collection;
use NumberFormatter;

class DashboardService
{
    public function getChartSeries(array $period, Collection $orders): array
    {
        return [
            $this->getOrderSerie($period, $orders),
            $this->getRevenueSeries($period, $orders)
        ];
    }

    private function getOrderSerie(array $period, Collection $orders): array
    {
        $serie = $this->getSerieArray('Bestellingen', $period);

        foreach ($orders as $order) {
            for ($i = 0; $i < count($period); $i++) {
                if ($this->checkDaysAreEqual($period[$i], $order)) {
                    $serie['data'][$i]['y']++;
                }
            }
        }
        return $serie;
    }

    private function getRevenueSeries(array $period, Collection $orders): array
    {
        $serie = $this->getSerieArray('Omzet', $period);

        foreach ($orders as $order) {
            for ($i = 0; $i < count($period); $i++) {
                if ($this->checkDaysAreEqual($period[$i], $order)) {
                    $orderPriceTotal = 0;
                    foreach ($order->products as $product) {
                        $quantity = $product->pivot->quantity;
                        $orderPriceTotal += $product->price * $quantity;
                    }
                    $serie['data'][$i]['y'] += $orderPriceTotal;
                }
            }
        }

        for ($i = 0; $i < count($serie['data']); $i++) {
            $serie['data'][$i]['y'] =$serie['data'][$i]['y'] / 100;
        }
        return $serie;
    }

    public function checkDaysAreEqual($period, $order): bool
    {
        $day = $order->created_at->startOfDay();
        $periodDay = $period->startOfDay();

        return $day->diffInDays($periodDay) === 0;
    }

    private function getSerieArray(string $label, array $period): array
    {
        $serie = [
            'name' => $label,
            'data' => [],
        ];

        for ($i = 0; $i < count($period); $i++) {
            $serie['data'][$i]['x'] = $period[$i]->format('d M');
            $serie['data'][$i]['y'] = 0;
        }

        return $serie;
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
