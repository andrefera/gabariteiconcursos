<?php

namespace App\Modules\Admin\Orders\Services\Actions;

use App\Models\Order;
use App\Support\DTO\SuccessResponseDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

readonly class UpdateOrdersStatus
{
    public function __construct(
        private array  $ids,
        private string $status,
    )
    {
    }

    public function execute(): SuccessResponseDTO
    {
        try {
            DB::beginTransaction();

            $orders = Order::query()->whereIn('id', $this->ids)->get();

            /**
             * @var Order $order
             */
            foreach ($orders as $order) {
                $order->changeStatus($this->status);
                $order->save();
            }

            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();

            Log::error("Erro ao atualizar status dos pedidos: {$exception->getMessage()}");

            return new SuccessResponseDTO(true, "Erro ao atualizar status dos pedidos.");
        }

        return new SuccessResponseDTO(true);
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            $request->get('ids'),
            $request->get('status'),
        );
    }
}
