# Фотосервис

## Описание

Проект фотосервиса создавался в рамках подготовки к соревнованиям по WorldSkills.

Работа над проектом велась в 2020 году. В проекте использовались следующие технологии:
- HTML
- CSS
- JavaScript
- PHP
- MySQL

Для работы с базой данных использовалась библиотека [RedBeanPHP](https://redbeanphp.com/).

Для работы с пользовательским интерфейсом использовалась библиотека [jQuery](https://jquery.com).

## Описание проекта

Функционал неавторизованного пользователя:

- Регистрация
- Авторизация
- Просмотр фотографий
- Поиск фотографий

Функционал авторизованного пользователя:

- Добавление фотографий
- Редактирование своих фотографий
- Удаление своих фотографий
- Возможность делится фотографиями с другими пользователями
- Поиск фото других пользователей
- Вывод своих фото в личном кабинете
- Изменение пароля

## Описание реализуемых функций

### Регистрация
- имя и фамилия (обязательные поля, кириллица), 
- телефон (обязательный, уникальный), 
- пароль (обязательно наличие минимум одного символа верхнего и нижнего регистра, одной цифры, и спецсимвола «!, _, -, #», подтверждение пароля).

### Авторизация
- в роли логина используется номер телефона, указанный при регистрации.

### Выход
- при выходе происходит редирект на страницу авторизации.

### Загрузка фотографии
- название изображения (необязательное), 
- список хештегов (необязательно, разделитель решетка - #), 
- допустимые расширения файлов - jpg, jpeg или png.

### Изменение фотографии
- возможно изменить название и список хештегов.

### Удаление фотографии

### Поиск фотографий
- осуществляется по названию фото или хештегам.

### Изменение пароля
- подтверждается вводом старого.