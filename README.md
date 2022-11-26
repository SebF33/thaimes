# PROJET AVEC FRAMEWORK
![logo_thaimes](/.github/logo_thaimes.png)

**Titre : Thaimes**

**Accroche :**
*"Éclairons-nous de ce que l’on aime !"*

**Auteur : Sébastien Flouriot (SebF33)**

**Cahier des charges :**
Proposer une variété de sujets catégorisés sur lesquels il est possible de contribuer et discuter.
Mettre en place une interface d'administration avec indicateurs/statistiques.

:construction: Work in Progress


## :link: Liens
:earth_africa: **Site web :** https://www.thaimes.com

:clapper: **Démo :** https://youtu.be/_hl4ums-3L0

:octocat: **GitHub :** https://github.com/SebF33/thaimes


## :computer: Développement
**Description technique :** Le projet est codé sur le motif Modèle-vue-contrôleur (MVC). Il emploie plusieurs services et librairies.

**Langages :** PHP (POO), JavaScript.

[![Symfony](/.github/Symfony.png)](https://symfony.com) [![Doctrine](/.github/Doctrine.png)](https://www.doctrine-project.org) [![Composer](/.github/Composer.png)](https://getcomposer.org) [![Twig](/.github/Twig.png)](https://twig.symfony.com) [![Docker](/.github/Docker.png)](https://www.docker.com) [![PostgreSQL](/.github/PostgreSQL.png)](https://www.postgresql.org) [![Bootstrap](/.github/Bootstrap.png)](https://getbootstrap.com) [![Sass](/.github/Sass.png)](https://sass-lang.com) [![Webpack](/.github/Webpack.png)](https://webpack.js.org) [![RabbitMQ](/.github/RabbitMQ.png)](https://www.rabbitmq.com) [![MailCatcher](/.github/MailCatcher.png)](https://mailcatcher.me) [![SweetAlert](/.github/SweetAlert.png)](https://sweetalert2.github.io) [![ApexCharts](/.github/ApexCharts.png)](https://apexcharts.com) [![Akismet](/.github/Akismet.png)](https://akismet.com) [![Mercure](/.github/Mercure.png)](https://mercure.rocks)

:toolbox: **Technologies :**
- [Symfony 5](https://symfony.com/doc/5.4/index.html)
- [Doctrine](https://www.doctrine-project.org/projects/doctrine-orm/en/current/tutorials/getting-started.html)
- [Composer](https://getcomposer.org/doc)
- [EasyAdmin 4](https://symfony.com/bundles/EasyAdminBundle/current/index.html)
- [Twig](https://twig.symfony.com/doc/3.x)
- [PHPUnit](https://phpunit.readthedocs.io/fr/latest)
- [Docker](https://docs.docker.com)
- [PostgreSQL](https://www.postgresql.org/docs)
- [Bootstrap](https://getbootstrap.com/docs/5.1/getting-started/introduction)
- [Sass](https://sass-lang.com/documentation)
- [Webpack](https://webpack.js.org/concepts)
- [RabbitMQ](https://www.rabbitmq.com/documentation.html)
- [MailCatcher](https://mailcatcher.me)
- [SweetAlert 2](https://sweetalert2.github.io/#download)
- [ApexCharts](https://apexcharts.com/docs/installation)
- [Akismet](https://akismet.com/development)
- [Mercure](https://mercure.rocks/docs/getting-started)


### ![Docker_tiny](/.github/Docker_tiny.png) Docker
Pour lier la BDD à pgAdmin :
`docker network create --driver bridge pgnetwork`
`docker network connect pgnetwork thaimes-database`
`docker network connect pgnetwork pgadmin`


### ![Mercure_tiny](/.github/Mercure_tiny.png) Mercure
Le chat consiste à mettre en place différents groupes de conversation entre utilisateurs.
L'intérêt de Mercure est de gérer les messages reçus en temps réel via SSE (Server-sent event).

Pour lancer Mercure sur Windows :
`cd mercure`
`$env:ADDR=":3000";$env:SERVER_NAME=":3000";$env:MERCURE_JWT_KEY="I_l0v3_{M3rCuR3}&{5ymF0nY}~ifSeb";$env:MERCURE_EXTRA_DIRECTIVES="cors_origins http://127.0.0.1:3000 https://127.0.0.1:8000"; .\mercure.exe run -config Caddyfile.dev`


### ![RabbitMQ_tiny](/.github/RabbitMQ_tiny.png) RabbitMQ
Pour consommer les messages :
`symfony console messenger:consume async`


### ![Symfony_tiny](/.github/Symfony_tiny.png) Symfony 5
Pour vider les caches PHP :
`php bin/console cache:clear`

Pour faire un dump de la BDD :
`symfony run pg_dump --data-only > dump.sql`

Pour restaurer les données de la BDD :
`symfony run psql > dump.sql`


### ![Webpack_tiny](/.github/Webpack_tiny.png) Webpack
Pour compiler les assets :
`yarn encore dev --watch`


![avatar](/.github/avatar.png)