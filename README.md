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

```bash
  php artisan migrate:fresh
```
If Needed

```bash
  php artisan storage:link
```
7- Remove Any Storage Links and Links Again : If needed 

```bash
  php artisan db:seed
```
5- You Will Need To seed "Roles(MUST) , Admin and Maybe Pharmacy "

// TODO : Making each Seeder Take From the Lever Above 

6-To Run the Event Of Verification Don't Forget to "Work" the Queue ;
```bash
  php artisan queue:work
```


// TODO Changing Timestamp later 