<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;

	protected $appends = ['category'];
    protected $fillable = ['name', 'description', 'price', 'stock'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'pivot'];

    public function categories(): belongsToMany {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function getCategoryAttribute(): String {
        return implode(', ', $this->categories()->pluck('name')->toArray());  
    }
}
