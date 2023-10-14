<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as RoleModel;

class Role extends RoleModel
{
    use HasFactory;

    public $hidden = ['guard_name', 'updated_at'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function scopeSearchText($query, $searchText)
    {
        if (!is_null($searchText)) {
            return $query->where(function ($q) use ($searchText) {
                $q->where("name", "LIKE", "%" . $searchText . "%")
                    ->orWhere("created_at", "LIKE", "%" . $searchText . "%");
            });
        }
    }

    public function scopeDate($query, $date)
    {
        if (!is_null($date)) {
            return $query->whereDate('created_at', '=', date('Y-m-d', strtotime($date)));
        }
    }
}
