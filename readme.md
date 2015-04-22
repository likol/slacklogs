Slacklogs
=========

A logger for Slack Channels, built with Laravel and MongoDB

# 需求

* PHP Version >= 5.4
* PHP Extension : [Mcrypt], [mongo]
* [MongoDB]
* [Composer]

# Install from git

``` bash
$ git clone --depth 1 http://git.crenosmart.com:8080/crenosmart/slacklogs.git
$ composer install
```
# Set-up

先至 slack 新增一個自訂的機器人，並記下 Api token

``` bash
/var/www/slacklogs$ cp .env.example.php .env.php
/var/www/slacklogs$ sed -i 's/REPLACE/YOUR SLACK CUSTOMIZATION BOT API TOKEN/g' .env.php
```
# How to use

*   記錄頻道
    使用 `/invite log-bot` 將機器人邀請至該頻道

*   不再記錄
    使用`/kick log-bot` 將機器人移出該頻道

# crawler and save data

``` bash
#取得並記錄頻道資訊
/var/www/slacklogs$ php artisan slack:load-channels

#取得並記錄使用者資訊
/var/www/slacklogs$ php artisan slack:load-members

#取得並記錄聊天記錄
/var/www/slacklogs$ php artisan slack:load-messages
```
[Composer]: https://getcomposer.org/
[Mcrypt]: http://php.net/manual/en/book.mcrypt.php
[mongo]: http://php.net/manual/en/book.mongo.php
[mongoDB]: http://docs.mongodb.org/manual/administration/install-on-linux/

