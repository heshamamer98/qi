<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Status extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['title'];

    public function tasks()
    {
        return $this->hasMany(Status::class);
    }

    public static function getStatuses()
    {
        $statuses = Cache::remember('statuses', now()->addDay(), function () {
            return Status::all()->pluck('title', 'id')->toArray();
        });

        return $statuses;
    }
}
