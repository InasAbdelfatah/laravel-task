Task project

Prerequisites

1- install local server in your machine in order to provide mysql db
you can install xampp as localhost .
you can download xampp through this link : https://www.apachefriends.org/index.html
and install it. <br/>
2- setup composer in your machine

Installing

1- clone or download project from github.
2- open command prompt and change the path to the path of prject using cd command
3- run this command in cmd : [ composer install ] to install all the dependencies that the project needed.
4- create database in your local mysql server
5 in .env file write database name , username and password of database.
you can do thate by updating these parameters in .env :
DB_DATABASE=task
DB_USERNAME=root
DB_PASSWORD=

6-run migration by running this command in cmd : [php artisan migrate]
7- run this command [ php artisan db:seed ] to seed your database to create user with email admin@admin.com and password “123456”
8- run php artisan serve and open the link of serve in your browser.
9- login to dashboard using (email admin@admin.com and password “123456”).
