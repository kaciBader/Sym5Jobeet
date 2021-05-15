# Sym5Jobeet
Sym5Jobeet est une application symfony, developpée en suivant le tutorial original Jobeet, Dans cette application j'ai essayé d'adapter l'application original à Symfony 5.0



### Resumé 
* Utilisation de makerBundle pour la creation des entités, en utilisant  les annotation 

* Injection des repositories service directement dans les fonctions de controlleur afin des reccuperer les données de DB 

* Configuration d'une base de donnée SQLite 

* Routage par annotation directement dans les controlleur

* Utilisation de faker library pour la genération des data fixtures 

* Pagination en utilisant knplabs/knp-paginator-bundle
   -- pagination des jobs a l'interieur de chaque category 
  
### Installation
1. Reccuperer le code
Via Git clonner le dépot en utilisant la commande git suivante : 
```
git clone https://github.com/kaciBader/Sym5Jobeet.git
```
2. Télécharger les vendors
Via Composer executer la commande suivante 
```
Composer install
``` 

3. Configuration de la base de données 
* Dans le dossier var creez un fichier Sym5Jobeet_dev.db
* dans le fichier .env configurez votre base de données 
```
DATABASE_URL=sqlite:///%kernel.project_dir%/var/Sym5Jobeet_dev.db
```
* utilisez la commande ci-aprés pour creer votre base de données 
```
symfony console doctrine:database:create
```
* Créez les tables correspondantes au schéma Doctrine :


4. Tests
executez les commande suivante pour lancer les tests
```
cd Sym5Jobeet/
./bin/phpunit
```
