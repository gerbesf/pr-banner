# PR-Server-Banner *beta*
Project Reality Server Banner

**Remove vendor folder for new install**

## Server requeriments
```
sudo npm install puppeteer
-- or --
sudo npm install -g puppeteer --unsafe-perm=true  
```


##  .env file

### Sqlite - ( File Database )
```
# touch database/database.sqlite
```

#### .env
```
DB_CONNECTION=sqlite
```

### Mysql 

#### .env
```
DB_CONNECTION=mysql
DB_HOST=your_database_ip
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=
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
