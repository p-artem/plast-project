# Yii 2 plast-project

### Установка Composer
#### Установка Composer на Linux и Mac OS X

Для установки Composer на Linux и Mac OS X выполните следующие 2 команды:
```
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```
Если у Вас не установлен curl, Вы также можете скачать файл [installer](http://getcomposer.org/installer) и затем запустить:
```
php installer
sudo mv composer.phar /usr/local/bin/composer
```
Установка Composer на Windows

Скачайте установочный файл из [getcomposer.org/download](https://getcomposer.org/download), запустите и следуйте инструкциям.

После установки Composer нужно запустить следующую команду:
```
composer global require "fxp/composer-asset-plugin:^1.2.0"
```
Команда устанавливает composer asset plugin, который позволяет управлять зависимостями пакетов bower и npm через Composer. 


## Для локального запуска сайта необходимо:
Консольные команды выполнять находясь в корневом каталоге приложения.

1. Выполнить команду:
```
composer update
```
2. В файле .env прописать необходимые настройки для подключения к БД.
3. Выполнить команду:
```
php console/yii app/setup --interactive=0
```
(будут применены миграции и сконфигурировано приложение)

Для удаления таблиц по миграциям выполнить:
```
php console/yii migrate/down 99 --interactive=0
```
Debug-toolbar
https://github.com/yiisoft/yii2-debug/pull/198/commits/a3e0667eb70b9b73aa5887cb26172f8e375aac5c