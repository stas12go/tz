# tz
Доступны CLI-команды:

`./command redis add {key} {value}`

`./command redis delete {key}`.

Веб-"интерфейс" написан под апач (присутствует `.htaccess` для обрезки расширений файлов).
Страница пустая, список записей из Redis загружается с помощью `fetch()`, таким же образом записи и удаляются из Redis.

Использовал композер для загрузки `predis/predis`.
