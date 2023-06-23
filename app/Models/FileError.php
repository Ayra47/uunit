<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileError extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'file_error';

    protected $fillable = [
        'page',
        'name',
        'file_id',
        'description'
    ];
    
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
