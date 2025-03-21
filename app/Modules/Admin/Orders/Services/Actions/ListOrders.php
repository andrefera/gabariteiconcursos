<?php

namespace App\Modules\Admin\Orders\Services\Actions;

use App\Models\Order;
use App\Modules\Admin\Orders\DTO\ListOrdersDTO;
use Carbon\Carbon;
use Illuminate\Http\Request;

readonly class ListOrders
{
    public function __construct(
        private ?string $id,
        private ?string $name,
        private ?string $email,
        private ?string $status,
        private ?string $init_date,
        private ?string $final_date,
        private int     $page = 1,
        private int     $limit = 50
    )
    {
    }

    public function execute(): ListOrdersDTO
    {
        $orders = Order::query()
            ->when($this->status, fn($query) => $query->where('status', $this->status))
            ->when($this->id, function ($query) {
                $query->where(fn($query) => $query->where('id', $this->id)->orWhere('increment_id', $this->id));
            })
            ->when($this->name, function ($query) {
                $query->whereHas('user', fn($query) => $query->where('name', 'like', '%' . $this->name . '%'));
            })
            ->when($this->email, function ($query) {
                $query->whereHas('user', fn($query) => $query->where('email', 'like', $this->email));
            })
            ->when($this->init_date, function ($query) {
                $date = Carbon::parse("$this->init_date 00:00:00")->setTimezone('UTC');
                $query->whereDate('created_at', '>=', $date);
            })
            ->when($this->final_date, function ($query) {
                $date = Carbon::parse("$this->final_date 23:59:59")->setTimezone('UTC');
                $query->whereDate('created_at', '<=', $date);
            })
            ->orderByDesc('id')
            ->paginate($this->limit, ['*'], 'page', $this->page);


        return new ListOrdersDTO(
            $orders->items(),
            $orders->total(),
            $orders->currentPage(),
            $orders->lastPage(),
            $this->limit
        );

    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('id'),
            $request->get('name'),
            $request->get('email'),
            $request->get('status'),
            $request->get('init_date'),
            $request->get('final_date'),
            $request->get('page'),
            $request->get('limit')
        );
    }
}
