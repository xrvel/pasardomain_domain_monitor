# Pasardomain Domain Monitor

## Apa Ini ?

Untuk monitor domain (exp date, dll), bisa diinstall di localhost.
Script ini berbasis Codeigniter 4.


## Cara Install
- Buat database di phpmyadmin, misal namanya **whoismon**
- Buka file `/docs/sql.txt`, file ini berisi struktur tabel mysql. import ke database.
- Buka file `/.env`, sesuaikan path `app.baseURL`
- Buka file `/.env`, sesuaikan nilai dari `database.default.`

## Server Requirements (copas dari CI 4)

PHP version 7.2 or higher is required, with the following extensions installed: 

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)
