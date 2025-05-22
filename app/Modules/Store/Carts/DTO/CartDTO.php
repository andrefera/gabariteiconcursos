<?php

namespace App\Modules\Store\Carts\DTO;

use App\Models\Cart;
use App\Models\CartItem;
use App\Modules\Store\CartItems\DTO\CartItemDTO;

readonly class CartDTO
{
    public function __construct(
        public int    $id,
        public array  $products,
        public int    $totalProducts,
        public float  $subTotal,
        public float  $total,
        public float  $finalPrice,
        public ?float $discount,
        public float  $shipping,
        public array  $installments,
    ) {}

    public static function fromCart(Cart $cart): self
    {
        $products = $cart->items->map(fn(CartItem $cartItem) => CartItemDTO::fromCartItem($cartItem));
        $totalProducts = $products->sum('quantity');
        $price = $products->sum('price');
        $specialPrice = $products->sum('specialPrice');
        $shipping = $cart->shipping()?->price ?? 0;
        $finalPrice = $specialPrice + $shipping;

        $maxInstallments = self::getInstallmentValue($specialPrice + $shipping);
        $amounts = [];
        $interestRate = 0.0150;

        for ($i = 1; $i <= $maxInstallments; $i++) {
            if ($i < 5) {
                // Sem juros
                $base = $finalPrice / $i;
                $installments = [];

                for ($j = 1; $j < $i; $j++) {
                    $installments[] = round($base, 2);
                }

                $sumSoFar = array_sum($installments);
                $installments[] = round($finalPrice - $sumSoFar, 2);

                // Retorna valor unitário médio ajustado
                $amounts[$i] = round(array_sum($installments) / $i, 2);
            } else {
                // Com juros compostos
                $totalWithInterest = $finalPrice * pow(1 + $interestRate, $i);
                $base = $totalWithInterest / $i;
                $installments = [];

                for ($j = 1; $j < $i; $j++) {
                    $installments[] = round($base, 2);
                }

                $sumSoFar = array_sum($installments);
                $installments[] = round($totalWithInterest - $sumSoFar, 2);

                // Retorna valor unitário médio ajustado
                $amounts[$i] = round(array_sum($installments) / $i, 2);
            }
        }

        return new self(
            $cart->id,
            $products->all(),
            $totalProducts,
            $specialPrice,
            $price,
            $finalPrice,
            ($price - $specialPrice > 0) ? $price - $specialPrice : null,
            $shipping,
            $amounts
        );
    }

    private static function getInstallmentValue(float $totalCart): int
    {

        $maxPermitted = floor($totalCart / 10);

        if ($maxPermitted < 1) {
            $maxPermitted = 1;
        } elseif ($maxPermitted > 12) {
            $maxPermitted = 12;
        }

        return intval($maxPermitted);
    }
}
