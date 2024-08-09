<?php

namespace App\Http\Controllers;

use LdapRecord\Container;
use LdapRecord\Connection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use LdapRecord\Models\ActiveDirectory\User;

class LdapController extends Controller
{
    public function search($uid)
    {
        $password = 'LdapDeV123456++';
        $baseDn = Config::get('ldap.connections.default.base_dn');
        $username = "uid=$uid,$baseDn";

        // $username = "CN=ldapdev,OU=DEV,OU=Technique,OU=SAMDOM_Utilisateurs,DC=samdom,DC=b2pweb,DC=com" ;
        $config = Config::get('ldap.connections.default');

        // Modifier la configuration avec les identifiants dynamiques
        $config['username'] = $username;
        $config['password'] = $password;



        // Créer une nouvelle connexion LDAP avec la configuration mise à jour
        $connection = new Connection($config);

        // Définir cette connexion comme la connexion par défaut
        Container::addConnection($connection);


        $user = User::where('uid', '=', $uid)->first();


        if ($user) {
           return dd([
                'status' => 'success',
                'data' => $user->getAttributes(),
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ]);
        }
    }
}
