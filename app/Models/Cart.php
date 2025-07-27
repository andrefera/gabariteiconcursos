<?php

namespace App\Models;

use App\Models\Enums\CartStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'token',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function shippings(): HasMany
    {
        return $this->hasMany(CartShipping::class, 'cart_id', 'id');
    }

    public function shipping(): ?CartShipping
    {
        return $this->shippings()->orderBy('created_at', 'desc')->first();
    }

    public static function cloneCart(self $cart, ?string $userId, string $sessionToken): self
    {
        $newCart = $cart->replicate();

        $newCart->user_id = $userId;
        $newCart->token = $sessionToken;
        $newCart->save();

        foreach ($cart->items as $item) {
            $newItem = $item->replicate();
            $newItem->cart_id = $newCart->id;
            $newItem->save();
        }

        $newCart->refresh();

        return $newCart;
    }

    public function close(): void
    {
        $this->status = CartStatus::CLOSED->value;
        $this->save();
    }
}
