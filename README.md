Procédure à suivre à l'installation : 

Installation des vendors :
composer install / composer update

Création de la base de doonées :
php app/console doctrine:schema:update --force

Création d'un utilisateur SUPER ADMIN
php app/console fos:user:create <username> <email> <password> --super-admin

Création d'un utilisateur simple 
php app/console fos:user:create <username> <email> <password>