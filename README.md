# action-task-list

# installation

run following command to import project in the command line.
git should be installed
```
git clone https://github.com/mehmetuygun/action-task-list.git
```

go to under application directory and
run following command to update dependency in the command line.
composer should be installed
```
composer update
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

/** this command will seed action table according to database/data/test_data.json
php artisan db:seed
```

navigate to app /pub folder when you open app in browser

I will reorganize codes when I have time so you can have better understanding.
