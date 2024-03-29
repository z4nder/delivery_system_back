<?php

namespace App\Models;

use App\Models\Additional;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function additionals()
    {
        return $this->belongsToMany(Additional::class, 'product_additionals');
    }

    static function findByUser($id, $user_id) {
        $response = self::where('id', $id)->where('user_id', $user_id)->first();
        if(isset($response)){
            return $response;
        }else {
            abort(404);
        }
    }
}
