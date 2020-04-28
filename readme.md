# Kurteyki App

LMS (Learning Management System) & Blog.

![alt Site](https://i.ibb.co/mtbfvhh/screencapture-localhost-kurteyki-2020-04-15-19-59-34.png)
![alt App](https://i.ibb.co/GVsBVMY/screencapture-localhost-kurteyki-app-2020-04-15-19-52-52.png)

## Fitur Aplikasi

* LMS (Learning Management System)
* Blog

## Langkah Awal Memulai

Intruksi dibawah ini akan mengarahkan anda untuk menjalankan project pada komputer anda (local) dan ditujukan hanya untuk melakukan development dan testing saja.

### Menjalankan Aplikasi Menggunakan XAMPP

```
Pastikan anda sudah menjalankan module xampp yaitu apache server dan mysql.
Download Project ini dan extract di folder htdocs yang ada pada xampp.
```

Buat Database dengan nama kurteyki di phpmyadmin, silahkan akses url dibawah ini untuk membuka phpmyadmin :

```
http://localhost/phpmyadmin
```

Kemudian import kurteyki.sql yang ada ddidalam folder ini

Langkah kedua akses url dibawah ini, disamakan dengan nama folder pada saat extract project ini pada htdocs xampp :

```
http://localhost/kurteyki
```

Informasi App

```
Halaman App : http://localhost/kurteyki/app

Default login
username : kurteyki
password: kurteyki
```

## Dibuat dengan

* [CodeIgniter 3.11](https://codeigniter.com/)

## Pembuat

* **Riedayme** - [Riedayme](https://facebook.com/riedayme)

## Work List

* Multiple user > instructor for lms
* Review lms by user
* user register vertivication...
* cookie setting

## Bug

* currency format on settings page
* language english
* when order using coupon and transaction using midtrans, coupon code will reuse again...

## License

This project is licensed under the MIT License.
