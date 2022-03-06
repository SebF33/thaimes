# PROJET AVEC FRAMEWORK
**Titre : Thaimes**

**Auteur : Sébastien Flouriot (SebF33)**

Site web : https://www.thaimes.com

Vidéo : https://youtu.be/_hl4ums-3L0

Accroche :
*"Éclairons-nous de ce que l’on aime !"*

Description :

Langages : PHP (POO), JavaScript.

Technologies:
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


### Symfony 5
Pour vider tous les caches PHP :
`php bin/console cache:clear`

Pour faire un dump de la BDD :
`symfony run pg_dump --data-only > dump.sql`


### Webpack
Pour compiler les assets :
`yarn encore dev --watch`