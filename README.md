# PR-Server-Banner *beta*
Project Reality Server Banner


## Server requeriments
```
sudo npm install puppeteer
-- or --
sudo npm install -g puppeteer --unsafe-perm=true  
```


##  .env file

### Sqlite - ( File Database )
```
 touch database/database.sqlite
```

#### .env
```
DB_CONNECTION=sqlite
```

### Mysql 

#### .env
```
DB_CONNECTION=mysql
DB_HOST=192.168.1.86
DB_PORT=3306
DB_DATABASE=divsul_banner
DB_USERNAME=root
DB_PASSWORD=local@168
```

## Installation


Unique App Key
```
# php artisan key:gen
```

Database Migration
```
# php artisan migrate
```

Administrative user
```
# php artisan create:user Name Email Password
```

## Manager
Access **yourdomain/admin**


### Cron
```
* * * * * curl -silent yourdomain
```
