<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    public const CURRENCY_EUR = 'EUR';
    public const CURRENCY_USD = 'USD';

    public const CURRENCIES = [
        self::CURRENCY_EUR,
        self::CURRENCY_USD,
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'currency',
        'amount',
        'product_id',
    ];
}
