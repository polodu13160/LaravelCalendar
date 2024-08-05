
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
