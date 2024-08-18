# Installation
1. Clonez le dépot chez vous puis Lancez la commande : `composer install`
2. Lancez la migration : `php bin/console d:s:u --force` apres avoir créé une base de donnée mysql nommée : boutique (penser à parametrer les acces mysql dans le fichier .env)
3. lancer la commande : php -S localhost:8000 -t public pour démarer le serveur web

4. essayer d'acceder à l'url http://localhost:8000/admin/inscription pour créer un compte
5. essayer de se connecter pour parametrer votre boutique

