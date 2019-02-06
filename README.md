# symfony-cd-epi
Projet Symfony pour les étudiants du cours décalé

Cloner le projet : 

    $ git clone https://github.com/changuelsami/symfony-cd-epi.git

Changer de dossier : 

    $ cd symfony-cd-epi

Installer les bundles (vendors) - Attention vous devez installer composer ou au moins copier composer.phar dans le dossier courant

    $ composer install
ou

    $ php composer.phar install

Pour faire fonctionner le champs WYSIWYG du formulaire des catégories :
    $ php bin/console ckeditor:install
    $ php bin/console assets:install
