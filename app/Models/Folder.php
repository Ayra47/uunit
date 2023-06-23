<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'folder';
    
    protected $fillable = [
        'name',
        'folder_name',
        'name',
        'path'
    ];

    public function files(): HasMany
    {
        return $this->hasMany(File::class, 'folder_id');
    }
}
