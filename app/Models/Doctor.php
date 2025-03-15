<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Doctor extends Model
{
    use HasFactory;
    protected $table = 'doctors';
    protected $fillable = ['user_id', 'specialty'];
    protected $appends = ['name'];
    protected $hidden = ['user']; 


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function availableTimes(): HasMany
    {
        return $this->hasMany(AvailableTime::class);
    }

    public function getNameAttribute()
    {
        return $this->user ? $this->user->name : null;
    }

} // end of Doctor
