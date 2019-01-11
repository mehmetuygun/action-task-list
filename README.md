# action-task-list

# installation

run following command to import project in the command line
```
git clone https://github.com/mehmetuygun/action-task-list.git
```
run following command to update dependency in the command line
```
git clone https://github.com/mehmetuygun/action-task-list.git
```
duplicate .env.example file then change it as .env
open the .env file and change following as your need
DB_DATABASE=yourdatabase
DB_USERNAME=yourdatabaseuser
DB_PASSWORD=yourdatabaseuserpassword

run following commmands to set up app in the command line
```
php artisan key:generate
php artisan migrate
/** if you already ran this command and getting error in the second time use command php artisan migrate:refresh **/
php artisan db:seed
```
