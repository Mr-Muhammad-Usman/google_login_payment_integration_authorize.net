<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthPaymentModel extends Model
{
    use HasFactory;

    protected $table='payment_logs';
}
