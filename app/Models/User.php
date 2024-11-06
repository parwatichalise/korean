<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'username',
        'contact',
        'role',
        'email',
        'password',
    ];
    public function Admin()
    {
        return $this->role === 'admin';
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
     /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin'; // Adjust this condition as needed
    }
    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'package_user'); // Adjust the pivot table name as needed
    }

    // Add your hasPurchasedPackage method here or keep it as is
    public function hasPurchasedPackage($packageId): bool
    {
        return $this->packages()->where('packages.id', $packageId)->exists();
    }

}
