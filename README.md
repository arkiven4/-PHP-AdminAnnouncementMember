# Admin Announce System
## Getting Started
### Instalation
- Place All file in your server
- Import SQL file to your database, see [this link](https://www.digitalocean.com/community/tutorials/how-to-import-and-export-databases-in-mysql-or-mariadb) or use this command : 
```sh
$ mysql -u username -p database_name < file.sql
```
- Go to `assets/php/theme.php` and change some variable
> theme.php
```php 
$GLOBALS['rootlink'] = "YOUR SITE LINK";
$GLOBALS['Site Title'] = "YOUR SITE TITLE";
```
> functions.php
```php 
$conn = mysqli_connect('Host', 'username', 'password', 'dbname', 'port');

//Example
$conn = mysqli_connect('mysql.lesterlive.com', 'devone', 'CodeByDevone0912!', 'devone_mbr');
```
- Done

### Set Admin User
- Register Your Account in the register page
- Open phpMyAdmin
- Goto to your database
- Select `user_data` table
- Find your email, or whatsapp, and change the admin from `0` to `1`
![Screenshot 2021-01-26 003259](https://user-images.githubusercontent.com/56885763/105742466-1f3c0300-5f6e-11eb-95d5-0d22d7c89e23.png)
- In the member area, log out and log in again to apply the change
- After Relogin , Now you can Access Admin Area
<div style="text-align:center"><img src="https://user-images.githubusercontent.com/56885763/105745525-f49f7980-5f70-11eb-89a3-89e5588e66ca.png" /></div>

### Admin Page
- Explore the admin Page, in the admin page, you can create post, delete post, edit post, and view post

