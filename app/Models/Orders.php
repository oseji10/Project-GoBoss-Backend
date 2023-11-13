<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{

    protected $table = 'orders';
    public $fillable = ['id', 'tracking_number', 'customer_id', 'customer_contact', 'customer_name', 'amount', 'sales_tax', 'paid_total', 'total', 'cancelled_amount', 'coupon_id', 'shop_id', 'parent_id', 'payment_gateway', 'shipping_address', 'billing_address', 'delivery_fee', 'order_status', 'payment_status', 'created_at', 'updated_at'];
    /**
     * @return belongsTo
     */
    public function customer(): belongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

}



