<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Jetstream\HasTeams;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto {
        HasProfilePhoto::profilePhotoUrl as getPhotoUrl;
    }
    use HasRoles;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the URL to the user's profile photo.
     */
    public function profilePhotoUrl(): Attribute
    {
        return filter_var($this->profile_photo_path, FILTER_VALIDATE_URL)
            ? Attribute::get(fn () => $this->profile_photo_path)
            : $this->getPhotoUrl();
    }

    public function setTeamsId($newteamId)
    {
        TeamUser::where('user_id', $this->id)->where('team_id', null)
            ->update(['team_id' => $newteamId, 'created_at' => now()]);
    }

    public function teamInvitation(): HasMany
    {
        return $this->hasMany(TeamInvitation::class);
    }


    public function assignRoleAndTeam($roleName, $teamId)
    {
       
        $this->assignRole($roleName);
        // $this->save();


        $this->setTeamsId($teamId);
        if ($this->current_team_id == null) {
            $this->current_team_id = $teamId;
        }
        $this->save();
    }

    public function canDoAction($roleName, $teamId): bool
    {
        $roleId = Role::where('name', $roleName)->first()->id;
        $roleAdminId = Role::where('name', 'Admin')->first()->id;


        // Vérifiez si l'utilisateur a le rôle dans l'équipe spécifiée
        $teamRole = $this->teams()->where('teams.id', $teamId)->first()->membership->role;

        if ($teamRole === $roleAdminId) {
            return true;
        }


        return $teamRole === $roleId;
    }

    public function createPrincipal()
    {
        $principal = new Principal();
        $principal->uri = 'principals/'. $this->username;
        $principal->email = $this->email;
        $principal->displayname = $this->username;
        $principal->save();
    }
}
