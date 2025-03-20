<?php

namespace App\Models;

use App\Models\Enums\OrderStatus;
use App\Models\Enums\PaymentStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'cart_id',
        'address_id',
        'status',
        'method',
        'total_price',
        'final_price',
        'discount',
        'installments',
        'installment_price',
        'coupon_id',
        'shipping_company',
        'shipping_price',
        'shipping_method',
        'shipping_days',
        'remote_ip',
        'user_agent',
        'paid_at',
        'cancelled_at',
        'refunded_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_price' => 'float',
        'final_price' => 'float',
        'discount' => 'float',
        'shipping_price' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class);
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(OrderPayment::class);
    }

    public function changeStatus(string $status): bool
    {
        $newStatus = $this->parseStatus($status);

        if ($this->status === $newStatus) {
            return false;
        }

        switch ($newStatus) {
            case OrderStatus::CANCELLED->value:
                $this->status = OrderStatus::CANCELLED->value;
                $this->cancelled_at = new Carbon();
                break;
            case OrderStatus::PAID->value:
                $this->status = OrderStatus::PAID->value;
                $this->cancelled_at = null;
                $this->paid_at = new Carbon();
                break;
            case OrderStatus::WAITING_PAYMENT->value:
                $this->status = OrderStatus::WAITING_PAYMENT->value;
                $this->cancelled_at = null;
                break;
            case OrderStatus::REFUNDED->value:
                $this->status = OrderStatus::REFUNDED->value;
                $this->cancelled_at = new Carbon();
                $this->refunded_at = new Carbon();
                $this->cancel();
                break;
            default:
                $this->status = OrderStatus::NEW->value;
                break;
        }

        return true;
    }

    private function parseStatus(string $paymentStatus): string
    {
        return match ($paymentStatus) {
            PaymentStatus::REFUSED->value, PaymentStatus::CHARGEDBACK->value, PaymentStatus::REJECTED->value, PaymentStatus::ERROR_INFRASTRUCTURE->value => OrderStatus::CANCELLED->value,
            PaymentStatus::PAID->value, PaymentStatus::APPROVED->value => OrderStatus::PAID->value,
            PaymentStatus::WAINTING_PAYMENT->value, PaymentStatus::PROCESSING->value => OrderStatus::WAITING_PAYMENT->value,
            PaymentStatus::REFUNDED->value => OrderStatus::REFUNDED->value,
            default => OrderStatus::NEW->value,
        };
    }
}
