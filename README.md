# PROJET AVEC FRAMEWORK
![logo_sebflix](/github/logo_thaimes.png)

**Titre : Thaimes**

**Accroche :**
*"Éclairons-nous de ce que l’on aime !"*

**Auteur : Sébastien Flouriot (SebF33)**

**Cahier des charges :**
Proposer une variété de sujets catégorisés sur lesquels il est possible de contribuer et discuter.
Mettre en place une interface d'administration avec indicateurs/statistiques.


## :link: Liens
:earth_africa: Site web : https://www.thaimes.com

:clapper: Démo : https://youtu.be/_hl4ums-3L0

:octocat: GitHub : https://github.com/SebF33/theme


## :computer: Développement
Description technique :

Langages : PHP (POO), JavaScript.

![Symfony](/github/Symfony.png) ![Composer](/github/Composer.png) ![Twig](/github/Twig.png) ![PostgreSQL](/github/PostgreSQL.png) ![Bootstrap](/github/Bootstrap.png) ![Sass](/github/Sass.png) ![Webpack](/github/Webpack.png) ![RabbitMQ](/github/RabbitMQ.png) ![MailCatcher](/github/MailCatcher.png) ![SweetAlert](/github/SweetAlert.png) ![ApexCharts](/github/ApexCharts.png) ![Mercure](/github/Mercure.png)

:toolbox: Technologies :
- Symfony 5
- Doctrine
- Composer
- EasyAdmin 4
- Twig
- PHPUnit
- Docker
- PostgreSQL
- Bootstrap
- Sass
- Webpack
- RabbitMQ
- MailCatcher
- SweetAlert
- ApexCharts
- Mercure


### Mercure
Le chat consiste à mettre en place différents groupes de conversation entre utilisateurs.
L'intérêt de Mercure est de gérer les messages reçus en temps réel via SSE (Server-sent event).

Pour lancer Mercure sur Windows :
`cd mercure`
`$env:ADDR=":3000";$env:SERVER_NAME=":3000";$env:MERCURE_JWT_KEY="I_l0v3_{M3rCuR3}&{5ymF0nY}~ifSeb";$env:MERCURE_EXTRA_DIRECTIVES="cors_origins http://127.0.0.1:3000 https://127.0.0.1:8000"; .\mercure.exe run -config Caddyfile.dev`


### RabbitMQ
Pour consommer les messages :
`symfony console messenger:consume async`


### Symfony 5
Pour vider les caches PHP :
`php bin/console cache:clear`

Pour faire un dump de la BDD :
`symfony run pg_dump --data-only > dump.sql`


### Webpack
Pour compiler les assets :
`yarn encore dev --watch`


![avatar](/github/avatar.png)