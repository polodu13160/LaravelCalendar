<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'personal_team',
    ];

    /**
     * The event map for the model.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
        ];
    }

    public function teamUser()
    {
        return $this->hasMany(TeamUser::class);
    }

    public function principal()
    {
        return $this->hasOne(Principal::class, 'id', 'principal_id');
    }
    public function createPrincipal()
    {
        $principal = new Principal();
        $hashDossier = $this->hashName();
        $principal->uri = 'principals/' . $hashDossier;
        $principal->displayname = $this->name;
        $principal->save();


        $this->principal_id = $principal->id;
        $this->save();

        return $principal;
    }
    public function hashName()
    {
        return substr(md5(hash('sha256', $this->name)), 0, 20);
    }

}
