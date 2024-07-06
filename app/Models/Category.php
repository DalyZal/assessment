<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'pivot'];

    public function products(): belongsToMany {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
