<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'original_url',
        'short_code',
        'user_id',
        'expires_at',
        'password',
        'is_custom',
        'is_active'
    ];
    
    protected $casts = [
        'expires_at' => 'datetime',
        'is_custom' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function visits()
    {
        return $this->hasMany(UrlVisit::class);
    }
    
    public function qrCode()
    {
        return $this->hasOne(QrCode::class);
    }
    
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'url_teams');
    }
    
    // Métodos útiles
    public function isExpired()
    {
        return $this->expires_at && now()->gt($this->expires_at);
    }
    
    public function getFullShortUrlAttribute()
    {
        return config('app.url') . '/' . $this->short_code;
    }
    
    public function getTotalClicksAttribute()
    {
        return $this->visits()->count();
    }
}
