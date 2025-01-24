<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'account_country',
        'account_name',
        'amount_due',
        'amount_paid',
        'auto_advance',
        'billing_reason',
        'collection_method',
        'currency',
        'user_id',
        'due_date',
        'number',
        'paid',
        'status',
        'subtotal',
        'subtotal_excluding_tax',
        'tax',
        'total',
        'total_excluding_tax',
        'metadata',
        'recurring_payment',
    ];

    protected $casts = [
        'amount_due' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'auto_advance' => 'boolean',
        'due_date' => 'datetime',
        'paid' => 'boolean',
        'subtotal' => 'decimal:2',
        'subtotal_excluding_tax' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'total_excluding_tax' => 'decimal:2',
        'metadata' => 'array',
        'recurring_payment' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = 'inv_' . (string) \Illuminate\Support\Str::uuid();
        });
    }
}
