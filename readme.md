
# Symfony 6 + PHP 8.0.13 with Docker

**ONLY for DEV, not for production**
## Run Locally
- Clone the project

| With SSH :                            | with HTTPS                                 |
|---------------------------------------|--------------------------------------------|
| `git@github.com:TeSdY14/sf6-test.git` | `https://github.com/TeSdY14/sf6-test.git`  |

- Enter the project directory
```bash
 cd sf6-test/
```

- If you are using Docker, Run the docker-compose
```bash
  docker-compose build
  docker-compose up -d
```
```bash git@github.com:TeSdY14/sf6-test.git ```

- Log into the PHP container

```bash docker exec -it php8-sf6 bash ```

Now, in this terminal, you can enter your Symfony/Composer/PHP/Linux/... commands for this docker container

- With Docker or not (Without Docker, you need to have PHP and Symfony Cli installed, read more below for more informations) 

Launch the Symfony application ``` symfony serve -d ```

(with SYMFONY : `symfony serve` [-d] option "-d" to detach (the terminal will be free) : https://www.php.net/manual/fr/features.commandline.webserver.php)

(with PHP : `PHP -S localhost:8080` : https://www.php.net/manual/fr/features.commandline.webserver.php)

*Your application is available at http://127.0.0.1:8080*

info for database are availables in .env file :
```yaml
  DATABASE_URL="postgresql://easypicky:pouet@ep-dbpsql:5432/easypicky?charset=utf8"
```

## YOU ARE USING DOCKER ##
## Ready to use with
This docker-compose provides you :
- PHP-8.0.13-cli (Debian)
    - Composer
    - Symfony CLI
    - and some other php extensions
    - nodejs, npm, yarn
- mailcatcher


## Requirements
Out of the box, this docker-compose is designed for a Linux operating system, provide adaptations for a Mac or Windows environment.
- Linux (Ubuntu 20.04 or other)
- Docker
- Docker-compose

## YOU ARE NOT USING DOCKER ##
You can launch the application directly with PHP or Symfony Local Web Server if all necessary components are installed on your machine.
#### The needs 
- PHP 8.1: https://www.php.net/releases/8.1/en.php -> PHP extensions are normally installed and enabled by default 
with PHP 8.1
https://symfony.com/doc/current/setup.html#technical-requirements
- Composer (install PHP Dependencies): https://getcomposer.org/download/
- Symfony CLI (To use Symfony commande (it replaces "php bin/console"): https://symfony.com/download

##### Useful command to start local server easily (run it in the root of symfony project) :
``` symfony serve -d ```

If you run with docker { open **http://localhost:8080/** }

Else { open **http://localhost** }


### Technical choice : 
- PHP 8.0.3 
- Symfony 6.0.9
- Docker
- GitHub 
- Postgresql 14

=> I'm working on Linux Ubuntu 21.10 with PhpStorm

### Components 
#### Administration 
EasyAdmin 4
https://github.com/EasyCorp/EasyAdminBundle
Administration Security : FormLogin https://symfony.com/doc/current/security.html#form-login 

#### API 
ApiPlatform
https://api-platform.com/

#### Security
JWT : LexikJWTAuthenticationBundle
https://github.com/lexik/LexikJWTAuthenticationBundle/blob/2.x/Resources/doc/index.rst#installation


## Test API 
I use Postman to send requests to the API 

You need to get the Bearer Token to query the API

Post a request to the api with one of the users listed below

With Postman create a new Query 

Choose **POST** method 

Enter `http//localhost:8080/api/login` as URL 

Click on the tab *Body* below the URL field

Select "Raw" and to the right of "GraphQL" tab, choose "JSON" 

In the text area enter : 
```JSON
{
    "username": "admin@easypicky.fr",
    "password": "pouet"
}
```
The API returns the Admin bearer token.
Check the "Body response" (Choose Pretty and JSON format - right tab) 

you show something like :
```json 
{
"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eblablablablablablaTIsImV4cCI6MTY1NjUzNDc5Miwicm9sZXMiOlsipouetJTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6ImFkbWluQGVhc3lwaWNreS5mciJ9. ee1jKniQsOcFblablablablablablablaSxKbl8A0TDcS9uoXrJ5KjWAnIbI49eMNUybCuIzfnfKgUzCSJGJTkM_0sY0RPJmWcDTsfFnglDz4hTgt6WJbAci3_VDbnP4iSMCShT2xsFdwYHGuPGizE1OLOwHqJEHlE98Gqid6IzqgzMaAMNHslmSghG_jEmxOC7xGHy4sAjbWmOqrZiKfxRbRDnZMh8HVPTlBWVj3Hspuoqekrb_1Lgq5NrG_kIXFa8Oxkz5a5IqjJB_qTJ_gQHZWamrFOmeL-sLnfZUR4pislgu7rJ0OOHkAOEctfghCsxVV5Pqw"
}
```

Copy this token. 

Now, for each query you need to give the token value to the API

**Authorization** > **Type:** "Bearer Token" > in the field **Token** enter the value "eyJ....."
(you can set the value of the bearer's token for the environment, but this is not the place to explain it perhaps).

No you can normally query the database.

Logins :
### ADMIN 
- username: `admin@easypicky.fr`
- password: `pouet` 

### Clients 
##### Client1 : 
- username: client1@easypicky.fr
- password: pouet
##### Client2
- username: client2@easypicky.fr
- password: pouet



EVOLUTIONS ENVISAGEABLES 
- Add tests 
- POST User (admin only) denormalizer to hashPassword 
- Build and access a config file (or something like that) to define which property each Client can "read"
- Adding more control rules on sent values (Constraint Validator as Length on Company->siren (min & max = 9)






##### Content of the mail sent to Fanny Barat
``` 
Bonjour

Bonne nouvelle, j'ai terminé le test, du moins la partie développement EST prête, je suis actuellement en train de fignoler la documentation (ReadMe.md sur le projet) 
Le projet est disponible ici https://github.com/TeSdY14/easypicky-test

GitHub - TeSdY14/easypicky-test: Made with Php 8 > Symfony 6 - Provides EasyAdmin administration and data available through ApiPlatform API (provides User and Company)
Made with Php 8 &gt; Symfony 6 - Provides EasyAdmin administration and data available through ApiPlatform API (provides User and Company) - GitHub - TeSdY14/easypicky-test: Made with Php 8 &gt; Sy...
[image]

Note à la personne en charge du contrôle - Le readme devrait être encore plus complet : 
J'utilise docker, si vous ne l'avez pas sur votre système rendez vous au point "Vous n'utilisez pas Docker" 
Sinon, vous avez ou pouvez avoir docker on continue : 
Depuis un terminal placé dans le répertoire du projet (cloné depuis GitHub), Entrer la commande :
docker-compose up [--force-recreate --build] 

Le projet sera disponible dans un conteneur docker ["ep-php" pour le projet Symfony et "ep-dbpsql" pour la base de données) 

Le conteneur du projet étant lancé,
Se rendre dedans afin de pouvoir exploiter les commandes Composer/Symfony/PHP/etc ... 
docker-compose exec ep-php bash

Le terminal est désormais ouvert dans le projet, se rendre dans le projet Symfony 
cd project 

Vous n'utilisez pas Docker  
Il vous faudra tous les composants indispensable à une application Symfony (PHP et ses extensions, Serveur (' Apache, Nginx, ...), BDD ...) 

Et maintenant il faut exécuter les commande d'initialisation d'un projet Symfony 
(La base de données : PostgreSQL)
Création de la base de données :
bin/console doctrine:database:create [ ou simplement bin/console d:d:c ]
Construire la base de données :
bin/console doctrine:migrations:migrate [ ou simplement bin/console d:m:m ]
Envoyer des données dans la base 
bin/console doctrine:fixtures:load   [ ou simplement bin/console d:f:l ]

Normalement, l'application est opérationnelle. 

Les liens utiles : 
Accès à l'administration : 
http://localhost:8080/admin 

Accès à la doc API 
http://localhost:8080/api/docs 

Pour utiliser la base de données, toutes les entités sont disponibles à partir de 
http://localhost:8080/api/[entities-names]

Administration (EasyAdmin) 
Seul un utilisateur Administrateur peut voir la page d'administration, CRUD disponible pour Company, DELETE est retiré pour les Users 
API (Api-Platform), il est possible de passer par la doc API pour effectuer les requêtes, personnellement j'utilise Postman : 
Règles :
Seul les requêtes GET (Item/Collection), Post et Patch sont disponibles sur Company. 
Seul l'administrateur peut POST ou PATCH sur l'ensemble de l'API,
La suppression d'utilisateur est impossible depuis l'administration,
Le client 1 peut faire du GET mais n'obtiendra que les infos de sa Company -> Tout sauf ID et Siren, 
Le client 1 peut faire du GET mais n'obtiendra que les infos de sa Company -> Uniquement Nom et Activité,
Aucun client ne peut voir les utilisateurs,
L'Admin peut effectuer toutes les opérations de Create, Read et Update (Put et Patch) sur l'API mais AUCUN DELETE,
Une contrainte de validation a été mis en place sur le Siren d'une Company (min et max = 9 caractères), 
j'ai ajouté une requête sur l'api/doc qui permet de récupérer un Token d'identification afin de tester depuis la doc, même si je ne recommande pas, mais cela évite d'installer un outil externe !
```
