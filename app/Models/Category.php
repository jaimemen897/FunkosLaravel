<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = ['name', 'is_deleted'];
    protected $keyType = 'string';
    public $incrementing = false;

    public function funkos()
    {
        return $this->hasMany(Funko::class);
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('name', 'LIKE', "%$search%");
        }
    }

    public function hasFunkos()
    {
        return $this->funkos->count() > 0;
    }

    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}
