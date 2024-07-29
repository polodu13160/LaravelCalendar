# Synchronisation des Événements et Fichiers ICS

Ce document décrit le processus de synchronisation des événements entre la base de données et les fichiers ICS en utilisant un watcher et des scripts de vérification.

## Introduction

Pour assurer la cohérence entre les événements stockés dans la base de données et les fichiers ICS, nous utilisons un watcher qui lance un script de vérification des modifications des deux côtés.

## Commandes Principales

### Lancer le Watcher

Le watcher permet de surveiller en continu les modifications et de lancer automatiquement les scripts de vérification. Pour démarrer le watcher, utilisez la commande suivante :

```bash
php artisan schedule:work

