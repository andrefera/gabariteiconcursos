<?php

namespace App\Modules\Admin\Dashboard\DTO;

readonly class DashboardDTO
{
    /**
     * @param string $final_price
     * @param string $total_freight
     * @param float[] $order_prices
     * @param string $liquid_total
     * @param string $cost_total
     * @param int $total
     */
    public function __construct(
        public string $final_price,
        public string $total_freight,
        public array  $order_prices,
        public string $liquid_total,
        public string $cost_total,
        public int    $total,
    )
    {
    }
}
