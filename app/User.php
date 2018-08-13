<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use hasRoles;

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return $this->slack_webhook_url;
    }

    /**
     * Route notifications for the Discord channel.
     *
     * @return string
     */
    public function routeNotificationForDiscordWebhook()
    {
        return $this->discord_webhook_url;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'slack_webhook_url', 'discord_webhook_url', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    /**
     * Function to check if user is an admin
     *
     * @return boolean
     */
    public function isAdmin() {
        if($this->hasRole('admin')) {
            return true;
        } else {
            return false;
        }
    }

    public function screenshots()
    {
        return $this->hasMany('App\Models\Screenshot');
    }
}
