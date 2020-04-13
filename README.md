# support-system
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Систему приёма и обработки заявок в техническую поддержку на Laravel/MySQL.

#### Установка
Загрузить и распаковать проект на нужное место.

Установка используемые пакеты через composer
``` bash
$ composer install
```
Переименовать файл .env.example на .env, там настройте подключения база данных и email сервер.

Создания таблицы в БД
``` bash
$ php artisan migrate
```
Нужен настроить хост на папку /public или переименовать файл .htaccess.example на .htaccess

#### Использование
Зарегистрируйте пользователя в системе и отметьте его как менеджера, используя следующую команду.
``` bash
$ php artisan manager:add <email>
```