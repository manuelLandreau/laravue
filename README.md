### Pré-requis

Pour lancer l'application, il vous faudra un environnement composé des technologies suivantes:

- Git ([?](https://git-scm.com/download/win))
- PHP >7.x ([?](https://www.grafikart.fr/tutoriels/php/php7-681))
- Composer ([?](https://www.grafikart.fr/tutoriels/php/composer-480))
- NodeJS >9.x ([?](https://openclassrooms.com/courses/des-applications-ultra-rapides-avec-node-js/installer-node-js))
- NPM >5.x ([?](https://www.npmjs.com/get-npm))
- Un serveur MySQL (ou Docker) ([?](https://openclassrooms.com/courses/administrez-vos-bases-de-donnees-avec-mysql/installation-de-mysql))

Commencez par cloner ce repo dans le dossier de votre choix :

`git clone ~liendurepo~ mygoodtest`

Placez vous dans le dossier :

`cd mygoodtest`

Installez les dépendances de Laravel avec Composer :

`composer install`

Installez les dépendances JS avec NPM :

`npm install`

Configurez votre fichier .env :

`mv .env.example .env`

Editez le .env avec votre [éditeur de texte préféré](https://atom.io/). ([?](https://laravel.com/docs/5.5/configuration))

Pensez à bien configurer votre .env en lui renseignant au minimum les identifiants de votre base de données SQL.

Générez la clé d'application pour Laravel :

`php artisan key:generate`

Lancer un serveur mysql par docker (optionnel) :

`docker-compose up -d`

Lancez les migrations de Laravel :

`php artisan migrate`

Générer des data fixtures :

`php artisan db:seed --class=UsersSeeder`

Lancez le serveur de développement de Laravel :

`php artisan serve`

Lancez le LiveReload avec NPM :

`npm run watch`

Builder Semantic UI :

`npm run semantic`

Des tests unitaires sont disponible avec l'environement "local":

`php vendor/bin/phpunit`

ou sous windows: 

`vendor\bin\phpunit.bat`

Linters : 

`php vendor/bin/php-cs-fixer fix app/http` ou `vendor\bin\php-cs-fixer.bat fix app/http`

`npm run lint`

## To do

- Plus de test
- Custom LESS variables
- Page d'enregistrement


> 📄 MyGoodTest
