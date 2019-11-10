# O-Tableau
Projet de fin de formation O'clock

## Objectif

Véritable simulation professionnelle (Gestion de Projet, Répartition des tâches, Travail en équipe...)

## Durée

1 mois

## Etapes (Sprints)

- Conception (Cahier Charges, User Stories, Wireframes, Spécifications fonctionnelles / techniques, MCD, Dico Données...)
- Organisation (Suivi des sprints avec Trello - To Do / Doing / Done)
- Développement
- Présentation Twitch

## Equipe

4 développeurs Symfony
- Kaïn MERIDJA => Lead Front + Fonctionnalité "Messagerie"
- Nicolas VIVAT => Lead Back + Fonctionnalité "Upload de Documents"
- Myriam BRINGEL => Product Manager + Fonctionnalité "Messagerie"
- Sébastien BINAUD (moi-même) => Product Owner + Fonctionnalité "Cantine + Calendrier"

## Pages développées à titre personnel

### Controller Gestion Calendrier et Cantine réservé au Directeur de l'école
[/src/Controller/Backend/AdminCalendarController.php](https://github.com/seb-linaseb/SEB_O-Tableau/blob/dev/src/Controller/Backend/AdminCalendarController.php)<br />
[/src/Controller/Backend/AdminCanteenController.php](https://github.com/seb-linaseb/SEB_O-Tableau/blob/dev/src/Controller/Backend/AdminCanteenController.php)

### Controller Gestion de la présence et cantine par les enseignants
[/src/Controller/User/CanteenController.php](https://github.com/seb-linaseb/SEB_O-Tableau/blob/dev/src/Controller/User/CanteenController.php)

### Création de la majorité des entités et relation ("maker" de Symfony)
[/src/Entity](https://github.com/seb-linaseb/SEB_O-Tableau/tree/dev/src/Entity)

### Génération automatique en PHP d'un calendrier "infini" mensuel et hebdomadaire
[/src/Utils/Calendar/Month.php](https://github.com/seb-linaseb/SEB_O-Tableau/blob/dev/src/Utils/Calendar/Month.php)<br />
[/src/Utils/Calendar/Week.php](https://github.com/seb-linaseb/SEB_O-Tableau/blob/dev/src/Utils/Calendar/Week.php)

### Consultation + Activation des jours travaillés sur Calendrier réservé au Directeur de l'école
[/templates/backend/calendar/create.html.twig](https://github.com/seb-linaseb/SEB_O-Tableau/blob/dev/templates/backend/calendar/create.html.twig)<br />
[/templates/backend/calendar/read.html.twig](https://github.com/seb-linaseb/SEB_O-Tableau/blob/dev/templates/backend/calendar/read.html.twig)

### Consultation + Mise à jour Cantine réservée au Directeur de l'école pour toutes les classes
[/templates/backend/canteen/read_week.html.twig](https://github.com/seb-linaseb/SEB_O-Tableau/blob/dev/templates/backend/canteen/read_week.html.twig)<br />
[/templates/backend/canteen/update_week.html.twig](https://github.com/seb-linaseb/SEB_O-Tableau/blob/dev/templates/backend/canteen/update_week.html.twig)

### Vue journalière des présences et repas (Enseignant)
[/templates/canteen/day.html.twig](https://github.com/seb-linaseb/SEB_O-Tableau/blob/dev/templates/canteen/day.html.twig)
