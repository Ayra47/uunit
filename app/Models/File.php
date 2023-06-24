<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'file';

    protected $fillable = [
        'name',
        'folder_id',
        'path',
        'is_ready'
    ];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(CompanyUser::class, 'folder_id');
    }
    
    public function errors(): HasMany
    {
        return $this->hasMany(FileError::class, 'file_id');
    }
}
