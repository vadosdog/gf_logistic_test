<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RonasIT\Support\Traits\ModelTrait;

/**
 * Модель доставки
 *
 * @property int $id
 * @property string $status
 */
class Delivery extends Model
{
    use HasFactory;
    use ModelTrait;

    public $fillable = ['status'];
}
