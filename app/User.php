<?php

namespace App;

use App\Traits\Boardable;
use App\Traits\HasInvites;
use Cog\Ban\Traits\HasBans;
use Laravel\Scout\Searchable;
use App\Models\Resources\Snippet;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Cog\Ban\Contracts\HasBans as HasBansContract;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements HasBansContract
{
    use Searchable, Notifiable, HasApiTokens, Impersonate, HasInvites, Boardable, HasBans;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'avatar', 'profile_cover', 'email', 'github_id', 'slack_webhook_url', 'password', 'is_admin', 'lat', 'lng', 'address', 'city', 'country', 'company', 'intro', 'website', 'github_url', 'twitter_url', 'facebook_url', 'linkedin_url', 'email_token', 'affiliate_id', 'referred_by', 'is_verified', 'is_sponsor'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'slack_webhook_url', 'github_id', 'affiliate_id', 'referred_by',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
        'is_verified' => 'boolean',
        'is_sponsor' => 'boolean',
    ];

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'users';
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }

    public function routeNotificationForSlack()
    {
        return $this->slack_webhook_url;
    }

    public function referrals()
    {
        $referrals = self::where('referred_by', $this->affiliate_id)->get();

        return $referrals;
    }

    /**
     * @return bool
     */
    public function canImpersonate()
    {
        return $this->is_admin;
    }

    /**
     * @return bool
     */
    public function canBeImpersonated()
    {
        if (! $this->is_admin) {
            return true;
        }
    }

    public function snippets()
    {
        return $this->hasMany(Snippet::class);
    }
}
