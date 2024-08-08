<?php

namespace App\Ldap\Rules;

use LdapRecord\Laravel\Auth\Rule;
use LdapRecord\Models\Model as LdapRecord;
use LdapRecord\Models\ActiveDirectory\Group;
use Illuminate\Database\Eloquent\Model as Eloquent;

class CheckAuthorizeUserCalendar implements Rule
{
    /**
     * Check if the rule passes validation.
     */
    public function passes(LdapRecord $user, Eloquent $model = null): bool
    {
        $groupAuthorized = 'CN=Hubspot_Calendar,OU=SAMDOM_Groupes,DC=samdom,DC=b2pweb,DC=com';
        $group = Group::find($groupAuthorized);
        if ($group) {
            // Vérifier si l'utilisateur fait partie du groupe
            return $group->members()->exists($user->getDn());
        }
        return false;


    }
}
