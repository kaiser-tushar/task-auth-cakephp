# Task-Auth-CakePHP

Task-Auth is a simple [CakePHP](https://github.com/cakephp/cakephp) (version 4) application that lets you register user, login with that user and you will see user list.

## Description
This application can create user by simple registration and show user list after login.

There are three task you can do - **Register** an user, **Login** with user email and password, **View** all user list.

### Prerequisites
```
PHP - minumum version PHP 7.2
CakePHP installation requirements
Javascript - need to enable javascript on browser
Composer to install required depndency
Database like MySQL
```

### Installing
 For cloning this project need to run
 ```
git clone https://github.com/kaiser-tushar/task-auth-cakephp
```
Go to project folder (ex: cd task-auth-cakephp) and run in cmd / terminal
```
composer install
```
Create a database on your preferred database engine like MySQL.

Go to Database folder alter_query.sql and run listed queries from that file on newly created database.Or you can run below SQL
```
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
```

Open config/app.php and update **Datasources** array **default** keys for Database connection if you are going to use MySQL database.
```
'Datasources' => [
    'default' => [
            'className' => Connection::class,
            'driver' => Mysql::class,
            'persistent' => false,
            'timezone' => 'UTC',
            'host' => 'localhost',
            'username' => 'db_user',
            'password' => 'db_pass',
            'database' => 'db_name',
    ],
];
```
![DB connection](https://imgur.com/BFNHjaH.png)

### Deployment
To run  this application locally in your machine run

```
bin/cake server
```
by default it will open in http://localhost:8765/

### Built With
This application is build with CakePHP version 4 and Javascript. I use CakePHP default ORM, validation and other convention, jQuery for Javascript, MySQL for database. I use [Meddo](https://medoo.in/) for ORM.Also for token based authentication I use  [JWT](http://jwt.io/)
