<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use eloquentFilter\QueryFilter\ModelFilters\Filterable;

class Item extends Model
{
    use Filterable;

    private static $whiteListFilter =[
        'name',
        'price',
        'size',
        'region_of_origin',
        'category_id',
        'sex',
        'color_id',
        'categories.name'
    ];

    // private $aliasListFilter = [
    //     'items.name' => 'item_name',
    // ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_url',
        'condition',
        'size',
        'region_of_origin',
        'category_id',
        'sex',
        'color_id',
        'is_sold',
        'is_deleted'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_sold' => 'boolean',
        'is_deleted'=>'boolean'
    ];

    /**
     * Get the category associated with the item.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the color associated with the item.
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}