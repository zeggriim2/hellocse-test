# Documentation Technique du Projet

## Description du Projet

Ce projet est une API développée avec Laravel 10/11 pour la gestion des **administrateurs** et des **profils**. L'API propose plusieurs endpoints protégés par authentification pour permettre la création, la modification et la suppression de profils, ainsi qu'un endpoint public pour récupérer les profils actifs.

### Fonctionnalités principales :
- Gestion des administrateurs (authentification requise).
- CRUD sur les profils (nom, prénom, image, status).
- Endpoints sécurisés avec authentification pour certaines opérations.
- Gestion des status des profils (inactif, en attente, actif).
- Upload et gestion d'images pour les profils.
- Tests unitaires pour valider les différentes fonctionnalités de l'API.

## Stack Technique

- **Langage** : PHP 8.x
- **Framework** : Laravel 10
- **Base de données** : MySQL 8.0.x
- **Gestion des conteneurs** : Docker
- **Serveur HTTP** : Dunglas FrankenPHP (inclus dans le Docker)
- **Tests** : PHPUnit
- **ORM** : Eloquent ORM (inclus avec Laravel)
- **Système de validation** : FormRequest
- **Authentification** : Par token (JWT ou session Laravel)

## Prérequis

- Docker et Docker Compose installés sur votre machine.
- PHP 8.x installé en local (optionnel pour un usage hors Docker).
- MySQL 8.x (peut être géré via Docker).
- Composer installé (gestionnaire de dépendances PHP/ gérer via Docker).

## Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/zeggriim2/hellocse-test.git
```
### 2. Configuration de l'environnement

```bash
cp .env.example .env
```

### 3. Installer les dépendances

```bash
composer install
```

### 4. Générer la clé d'application

```bash
php artisan key:generate
```

### 5. Lancer les conteneurs Docker
Assurez-vous que Docker est en cours d'exécution, puis exécutez :
```bash
docker-compose up -d
```

### 6. Migrer la base de données
Lancez les migrations pour configurer la base de données :
```bash
php artisan migrate
```

Si vous souhaitez générer des données de test avec des seeders :
```bash
php artisan migrate:fresh --seed
```

## Endpoints de l'API

### Authentification
* POST ```/api/admin/login``` : Connexion pour un administrateur.
    * Requête : ```email```, ```password```
    * Réponse : Token d'authentification.

### Profils
* POST ```/api/profils``` (Authentifié) : Créer un profil.
  * Requête : ```nom```, ```prenom```, ```image```, ```status```
  * Réponse : Détails du profil créé.


* GET ```/api/profils``` (Authentifié) : Créer un profil.
* PUT ```/api/profils/{id}``` (Authentifié) : Modifier un profil existant.
    * Requête : ```nom```, ```prenom```, ```image```, ```status```
    * Réponse : Détails du profil mis à jour.

* DELETE ```/api/profils/{id}``` (Authentifié) : Supprimer un profil.


## Contributeurs
- [Lilian Github](#https://github.com/zeggriim2)
- [Lilian Gitlab](#https://gitlab.com/zeggriim1)
