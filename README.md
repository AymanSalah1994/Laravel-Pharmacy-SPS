## The ".env" File is Removed From the GitIgnore file

If you are Cloning it From Github :

1- In the .env File Make Sure DB name is Correct and Everything is Fine and the Database exists ;

2-Install the Needed Packages :

```bash
 composer install
```

composer dump-autoload
[ If needed ]

3- Generate the Key For the App :

```bash
  php artisan key:generate
```

4- If the Database is Still Empty Migrate the Tables :

```bash
  php artisan migrate
```

php artisan migrate:fresh
If Needed

5- You Will Need To seed "Roles(MUST) , Admin and Maybe Pharmacy "
Just Seed the DataBase :
$ php artisan db:seed
// TODO : Making each Seeder Take From the Lever Above 
To Create More than One Phamracy Or Doctor You can Specify the Class
// TODO > Making Facotry For Big Number

6-To Run the Event Of Verification Don't Forget to "Work" the Queue ;

7- Remove Any Storage Links and Links agaign :
php artisan storage:link
For Local Storage ;
% TODO Changing Timestamp later 