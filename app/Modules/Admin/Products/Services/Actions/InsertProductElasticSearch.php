<?php

namespace App\Modules\Admin\Products\Services\Actions;

use App\Models\Product;
use App\Models\Enums\OrderStatus;
use App\Modules\Admin\Products\Mappers\ProductGenderMapper;
use App\Modules\Admin\Products\Mappers\ProductTypeMapper;
use App\Support\Util\ElasticSearchUtil;
use App\Support\Util\UrlUtil;
use Carbon\Carbon;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Illuminate\Support\Facades\Log;

readonly class InsertProductElasticSearch
{

    public function __construct(
        public Product $product
    )
    {
    }

    public function execute(): void
    {
        $index = config('services.elastic_search.products_index');

        if ($this->product->trashed()) {
            try {
                ElasticSearchUtil::delete($index, $this->product->id);
            } catch (ClientResponseException $e) {

            }
            return;
        }

        $doc = collect();
        $doc->push(['id' => $this->product->id]);
        $doc->push(['name' => $this->product->name]);
        $doc->push(['sku' => $this->product->sku]);
        $doc->push(['url' => $this->product->url]);
        $doc->push(['price' => $this->product->price]);
        $doc->push(['special_price' => $this->product->special_price]);
        $doc->push(['type' => (new ProductTypeMapper())($this->product->type)]);
        $doc->push(['is_active' => $this->product->is_active ? "Sim" : "Não"]);
        $doc->push(['team_id' => $this->product->team?->id]);
        $doc->push(['team_name' => $this->product->team?->name]);
        $doc->push(['team_url' => $this->product->team?->name ? UrlUtil::formatUrlKey($this->product->team->name) : '']);
        $doc->push(['team_country' => $this->product->team?->country]);
        $doc->push(['is_national' => $this->isNationalTeam()]);
        $doc->push(['gender' => (new ProductGenderMapper())($this->product->gender)]);
        $doc->push(['season' => $this->product->season]);
        $doc->push(['stock' => $this->product->getStock()]);
        $doc->push(['sizes' => $this->product->sizes()->pluck("name")]);
        $doc->push(['sizes_stock' => $this->product->sizes()->get()->map(function ($item) {
            return ['size' => $item->name, 'stock' => $item->stock];
        })]);
        $doc->push(['categories' => $this->product->categories()->pluck("name")]);
        $doc->push(['images' => $this->product->images()->pluck("url")]);
        $doc->push(['total_orders' => $this->getTotalOrdersCurrentMonth()]);
        $doc->push(['discount_percentage' => $this->calculateDiscountPercentage($this->product->price, $this->product->special_price)]);
        $doc->push(['created_at' => Carbon::parse($this->product->created_at)->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s')]);

        try {
            ElasticSearchUtil::update($index, $this->product->id, $doc->collapse()->toArray(), true);
        } catch (ClientResponseException $e) {
            Log::error("Erro ao enviar produto para o EL: " . $e->getMessage());
        }
    }

    private function calculateDiscountPercentage(float $originalPrice, ?float $specialPrice): ?int
    {
        if (!$specialPrice || $specialPrice >= $originalPrice || $originalPrice <= 0) {
            return null;
        }

        $discount = (($originalPrice - $specialPrice) / $originalPrice) * 100;
        return (int) round($discount);
    }

    private function isNationalTeam(): string
    {
        if (!$this->product->team?->country) {
            return "Não";
        }

        return trim($this->product->team->country) === 'BR' ? "Sim" : "Não";
    }

    private function getTotalOrdersCurrentMonth(): int
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $nextMonth = Carbon::now()->addMonth()->startOfMonth();

        $validStatuses = [
            OrderStatus::PAID->value,
            OrderStatus::IN_SEPARATION->value,
            OrderStatus::WAITING_FOR_CARRIER->value,
            OrderStatus::IN_TRANSPORT->value,
            OrderStatus::DELIVERED->value,
        ];

        return $this->product->orderItems()
            ->whereHas('order', function ($query) use ($currentMonth, $nextMonth, $validStatuses) {
                $query->where('created_at', '>=', $currentMonth)
                      ->where('created_at', '<', $nextMonth)
                      ->whereIn('status', $validStatuses);
            })
            ->sum('quantity');
    }

    public static function fromProduct(Product $product): self
    {
        return new self($product);
    }
}
