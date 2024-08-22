# Installation

Clone the repository then Run the command: composer install (in the project directory)

Start the migration: php bin/console d:s:u --force after having created a mysql database named: shop (remember to configure mysql access in the .env file (DATABASE_URL line))

run the command: php -S localhost:8000 -t public to start the web server

try to access the url http://localhost:8000/admin/registration to create an account

try to log in to configure your store

N.B: there is another project with Angular which consumes the API part of this project

