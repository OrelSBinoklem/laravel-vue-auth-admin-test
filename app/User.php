<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\VerifyEmail as VerifyEmailNotification;
use App\Notifications\ResetPassword as ResetPasswordNotification;

use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;

use App\Helpers\Contracts\ImmunityUsers as ImmunityUsersContract;
use App\Helpers\Contracts\BelongsToUsers as BelongsToUsersContract;

use App\Traits\ImmunityUsers;

use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject, MustVerifyEmail, BannableContract, ImmunityUsersContract, BelongsToUsersContract
{
    use Notifiable, Bannable, ImmunityUsers;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photo_url',
    ];

    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getPhotoUrlAttribute()
    {
        return 'https://www.gravatar.com/avatar/'.md5(strtolower($this->email)).'.jpg?s=200&d=mm';
    }

    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * @return int
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function isOAuth()
    {
        return !!$this->oauthProviders()->count();
    }

    public function roles() {
        return $this->belongsToMany('App\Role','role_user');
    }

    //  'string'  array('View_Admin','ADD_ARTICLES')
    //
    public function canDo($permission, $require = FALSE) {
        if($this instanceof BannableContract) {
            if($this->isBannedOptimizedFunction()) {
                return FALSE;
            }
        }
        if(is_array($permission)) {
            foreach($permission as $permName) {
                $permName = $this->canDo($permName);
                if($permName && !$require) {
                    return TRUE;
                }
                else if(!$permName  && $require) {
                    return FALSE;
                }
            }

            return  $require;
        }
        else {
            foreach($this->roles as $role) {
                foreach($role->permissions as $perm) {
                    //foo*    foobar***************************
                    if(str_is($permission,$perm->name)) {
                        return TRUE;
                    }
                }
            }
            return FALSE;
        }
    }

    // string  ['role1', 'role2']
    public function hasRole($name, $require = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);

                if ($hasRole && !$require) {
                    return true;
                } elseif (!$hasRole && $require) {
                    return false;
                }
            }
            return $require;
        } else {
            foreach ($this->roles as $role) {
                if ($role->name == $name) {
                    return true;
                }
            }
        }

        return false;
    }

    public function isSuperAdmin() {
        return !!$this->roles->where('id', 1)->count();
    }

    public function isBannedOptimizedFunction() {
        $is_banned = false;
        $this->bans->each(function ($item) use (&$is_banned) {
            if($item->expired_at === null || $item->expired_at->format('Y-m-d H:i:s') > Carbon::now()->format('Y-m-d H:i:s')) {
                $is_banned = true;
                return false;
            }
        });
        return $is_banned;
    }

    public function isBannedPermanentOptimizedFunction() {
        $is_banned = false;
        $this->bans->each(function ($item) use (&$is_banned) {
            if($item->expired_at === null) {
                $is_banned = true;
                return false;
            }
        });
        return $is_banned;
    }

    public function isBannedOrPermanentOptimizedFunction() {
        return $this->isBannedOrPermanentOptimizedFunctionAndModel()['ban'];
    }

    public function isBannedOrPermanentOptimizedFunctionAndModel() {
        $is_banned = false;
        $ban_model = false;
        $this->bans->each(function ($item) use (&$is_banned, &$ban_model) {
            if($item->expired_at === null) {
                $is_banned = true;
                $ban_model = $item;
                return false;
            }
            if($item->expired_at->format('Y-m-d H:i:s') > Carbon::now()->format('Y-m-d H:i:s')) {
                if(is_bool($is_banned)) {
                    $is_banned = $item->expired_at;
                    $ban_model = $item;
                } else {
                    if($item->expired_at->format('Y-m-d H:i:s') > $is_banned->format('Y-m-d H:i:s')) {
                        $is_banned = $item->expired_at;
                        $ban_model = $item;
                    }
                }
            }
        });
        return ['ban' => $is_banned, 'ban_model' => $ban_model];
    }

    public function banSync($ban) {
        $t = $this->isBannedOrPermanentOptimizedFunctionAndModel();
        $old_ban = $t['ban'];
        $old_ban_model = $t['ban_model'];

        if($old_ban === false) {
            if($ban === true) {
                $this->ban();
            }
            if(is_string($ban)) {
                $this->ban(['expired_at' => Carbon::parse($ban)]);
            }
        }

        if($old_ban instanceof Carbon) {
            if($ban === false) {
                $this->unban();
            }
            if(is_string($ban) && Carbon::parse($ban)->format('Y-m-d H:i:s') != $old_ban->format('Y-m-d H:i:s')) {
                $old_ban_model->fill(['expired_at' => Carbon::parse($ban)])->update();
            }
            if($ban === true) {
                $old_ban_model->fill(['expired_at' => null])->update();
            }
        }

        if($old_ban === true) {
            if($ban === false) {
                $this->unban();
            }
            if(is_string($ban)) {
                $old_ban_model->fill(['expired_at' => Carbon::parse($ban)])->update();
            }
        }
    }

    public function BelongsToUsers() {
        return $this;
    }
}
