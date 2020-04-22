

# まずはmacのローカルで動かした


```
composer self-update && composer create-project --prefer-dist cakephp/app ./

brew install mysql
mysql.server start
mysql_secure_installation
mysql -uroot -p
CREATE DATABASE cakephp3 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

config/app.php
# データベース設定
'username' => 'root',
'password' => 'password',
'database' => 'cakephp3',

cd app
bin/cake server
```

dbが通ってるかは見れる    

http://localhost:8765
http://localhost:8765/articles/index


## 簡単なCRUD


```
# ユーザ
bin/cake bake model users
bin/cake bake controller users
bin/cake bake template users
# タグを一気に
bin/cake bake all tags
```


http://localhost:8765/tags/add


http://localhost:8765/articles/tagged
http://localhost:8765/articles/tagged/funny


systemctl start httpd


## CakeDC


```
composer require cakedc/users:8.*
```




# dockerのメモ（動いてないよ）


```
docker-compose build
docker-compose exec app bash


docker-php-ext-install  -j$(nproc) iconv intl mbstring pdo_mysql opcache
docker-php-ext-enable xdebug

```
