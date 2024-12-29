# BW Detect Mobile

## Description

BW Detect Mobile est un plugin WordPress qui permet de détecter facilement les appareils mobiles, tablettes et ordinateurs de bureau. Il s'intègre parfaitement avec Bricks Builder et offre des fonctionnalités de détection avancées pour une meilleure expérience utilisateur adaptative.

## Caractéristiques

- Détection précise des appareils mobiles et tablettes
- Intégration native avec Bricks Builder
- Fonctions helper simples à utiliser
- Conditions personnalisées pour Bricks Builder
- Support multilingue

## Prérequis

- WordPress 5.0 ou supérieur
- PHP 8.0 ou supérieur
- Bricks Builder (recommandé, mais non obligatoire)

## Installation

1. Téléchargez le plugin
2. Uploadez-le dans le dossier `/wp-content/plugins/`
3. Activez le plugin dans le menu 'Plugins' de WordPress

## Utilisation

### Fonctions Helper PHP

// Vérifier si l'appareil est mobile (excluant les tablettes)
if (bw_is_mobile()) {
// Code pour mobile
}

// Vérifier si l'appareil est une tablette
if (bw_is_tablet()) {
// Code pour tablette
}

// Vérifier si l'appareil est un ordinateur de bureau
if (bw_is_desktop()) {
// Code pour desktop
}

// Utilisation avancée
$detector = bw_detect();
if ($detector->is('iPhone')) {
// Code spécifique pour iPhone
}

## Intégration Bricks Builder

Le plugin ajoute automatiquement un nouveau groupe de conditions dans Bricks Builder :

Device Detection
Is Mobile
Is Tablet
Is Desktop

## Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :

Forker le projet
Créer votre branche de fonctionnalité
Commiter vos changements
Pousser vers la branche
Créer une Pull Request
Licence
Ce plugin est sous licence GPL-2.0 ou ultérieure. Voir le fichier LICENSE pour plus de détails.

## Auteur

BulgaWeb - https://bulgaweb.com

## Changelog

0.3.0
Ajout de la traduction

0.2.0
Ajout des fonctions helper globales
Amélioration de l'intégration Bricks Builder
Correction de bugs mineurs

0.1.0
Version initiale
Détection basique des appareils mobiles
Intégration Bricks Builder

## Remerciements

Ce plugin utilise la bibliothèque Mobile-Detect pour la détection des appareils.
