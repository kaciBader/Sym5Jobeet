# Sym5Jobeet
Sym5Jobeet est une application symfony, developpée en suivant le tutorial original Jobeet, Dans cette application j'ai essayé d'adapté l'application original à symfony 5.0



### Adaptation 
* utilisation de makerBundle pour la creation des entités, en utilisant  les annotation (contrairement au tutorial original qui utilise le format yml, etant donné que format est deprectée depuis la version 3.3 de symfony pour decrire les entité)

* injection des repository des entités comme service directement dans les fonctions de controlleur 

* configuration d'une base de donnée SQLite (le tutorial original mis en place une base de données mysql)

* le routage est effectués  avec annotation directement dans les controlleur (dans le tutorial original le routage est effectuée en utilisant le format yml)

* utilisation de faker library de generate the data fixtures 

