<?php

namespace App\Ldap\Scopes;

use LdapRecord\Models\Model;
use LdapRecord\Models\Scope;
use LdapRecord\Query\Model\Builder;

class HubspotCalendarGroupScope implements Scope
{
    /**
     * Apply the scope to the given query.
     */
    public function apply(Builder $query, Model $model): void
    {
        $groupDn = 'CN=Hubspot_Calendar,OU=SAMDOM_Groupes,DC=samdom,DC=b2pweb,DC=com';
        $query->where('memberof', '=', $groupDn);
    }
}
