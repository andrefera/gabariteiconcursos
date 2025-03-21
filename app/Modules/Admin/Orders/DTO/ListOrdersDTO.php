<?php

namespace App\Modules\Admin\Orders\DTO;

use App\Models\Order;

class ListOrdersDTO
{
    /**
     * @var OrderDetailDTO[]
     */
    public array $orders;

    /**
     * @param Order[] $orders
     * @param int $total
     * @param int $currentPage
     * @param int $lastPage
     * @param int $limit
     */
    public function __construct(
        array      $orders,
        public int $total,
        public int $currentPage,
        public int $lastPage,
        public int $limit,
    )
    {
        $this->orders = array_map(fn(Order $order) => OrderDetailDTO::fromOrder($order), $orders);
    }
}
