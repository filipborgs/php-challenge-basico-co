<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title', 'type', 'description', 'filename',
        'height', 'width', 'price', 'rating'
    ];

    public function rules()
    {
        return [
            'title' => 'required',
            'type' => 'required',
            'price' => 'required',
        ];
    }
}