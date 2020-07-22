# Pasardomain Domain Monitor

## Apa Ini ?

Untuk monitor domain (exp date, dll), bisa diinstall di localhost dengan bantuan [Xampp](https://www.apachefriends.org/index.html).
Script ini berbasis Codeigniter 4.


## Cara Install
### Pengaturan Database
- Buat database di phpmyadmin, misal namanya **whoismon**
- Buka file `/docs/sql.txt`, file ini berisi struktur tabel mysql. import ke database menggunakan phpmyadmin.
- Pengaturan nama database, username mysql, password mysql, buka file `/.env`, sesuaikan nilai dari `database.default.`

### Lain-lain
- Buka file `/.env`, sesuaikan path `app.baseURL`
- Buka file `/docs/words.txt`, file ini berisi kata-kata yang akan diimport ke database. Isi sebanyak-banyaknya.
- Kalau di localhost, install [Composer](https://getcomposer.org/)

## Penggunaan Pertama Kali
### Import Kata Ke Database
Untuk import `/docs/words.txt` ke database :
- Buka di browser `http://localhost/CONTOH/pasardomain_domain_monitor/public/util/insert_domains`

### Update Data Domain
Untuk update data exp date domain dll
- Buka di browser `http://localhost/CONTOH/pasardomain_domain_monitor/public/cron/update_domains`

### Lihat Hasil
- Buka di browser `http://localhost/CONTOH/pasardomain_domain_monitor/public/`

## Server Requirements (copas dari CI 4)

PHP version 7.2 or higher is required, with the following extensions installed: 

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)
