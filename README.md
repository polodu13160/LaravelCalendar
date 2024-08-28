


# Installation du projet 

prendre la branche main2
installer les packages : composer install et npm install
remettre le .env s'il n'y en a pas : le .env.exemple


Modifier le dossier database si vous souhaitez modifier les informations quand on lance la migration de la base de données : 
php artisan migrate --seed 

ou si deja installé

php artisan migrate:fresh --seed

Faire un test pour voir si le ldap fonctionne : 
php artisan ldap:serve 


Actuellement il peut se connecter a la base de données LDAP, mais rien n'est paramétré  : 
pas de premiere connexion 
et la connexion se fait avec le DN et non le username 

J'ai envoyé a bastien mon idée de connexion; il faudra juste surchargé la methode login pour chercher dans la base LDAP deja mise en place le username et apres faire une connexion en recuperant le dn du username. 

puis faire la logique de premiere connexion : créer un utilisateur sur la base Mysql du serveur. 

On peut utiliser la methode pour créer des utilisateurs qui est présente dans la partie visuel de l'application pour l'admin. 


admin 
username : cleininger 
password  : password 



Avec l'admin on peut créer un utilisateur ou un groupe : 
juste a aller dans l'acceuil en cliquant sur le calendrier. 
puis en haut a droite sur le profil de l'admin. 
















# Synchronisation des Événements et Fichiers ICS

Ce document décrit le processus de synchronisation des événements entre la base de données et les fichiers ICS en utilisant un watcher et des scripts de vérification.

**Cette synchronisation se fait toutes les minutes.**

## Introduction

Pour assurer la cohérence, et la création entre les événements stockés dans la base de données et les fichiers ICS, nous utilisons un watcher qui lance un script de vérification des modifications des deux côtés.

## Commandes Principales

### Lancer le Watcher

Le watcher permet de surveiller en continu les modifications et de lancer automatiquement les scripts de vérification. Pour démarrer le watcher, utilisez la commande suivante :

```bash
php artisan schedule:work
```

### Consignes supplémentaires

- **Création de Groupes :** Si vous créez des groupes sans passer par l'application, assurez-vous d'ajouter l'admin à chaque groupe.

- **Vérification de la Planification :** Utilisez la commande suivante pour voir dans combien de temps la tâche est exécutée et pour vérifier les logs en cas de problème :

```bash
php artisan schedule:list
```

## Connexion à un Serveur Mail

Pour se connecter à un serveur mail, il faut une application comme Thunderbird et utiliser le mot de passe et l'email de l'utilisateur.

## Modification des Événements

Il est important de noter que les titres ou autres détails des événements ne peuvent pas être modifiés dans une application comme Thunderbird. Cependant, ces modifications peuvent être effectuées via l'application dédiée. La seule chose que l'on peut modifier sur Thunderbird  ou autres applications de ce type est la date, le jour, et si l'event se deroule sur un jour entier.

## Conclusion

En suivant ces instructions, vous assurerez une synchronisation efficace et continue entre votre base de données et vos fichiers ICS, maintenant ainsi la cohérence des événements.
