<?php

namespace Zareismail\NovaPriority\Models;

use Illuminate\Database\Eloquent\{SoftDeletes, Model};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Zareismail\NovaContracts\Models\AuthorizableModel; 
use Spatie\EloquentSortable\{Sortable, SortableTrait};

class NovaPriority extends Model implements Sortable
{
    use HasFactory, SoftDeletes, SortableTrait;

	public $sortable = [
	    'order_column_name'  => 'primacy',
	    'sort_when_creating' => true,
	];
}
