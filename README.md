<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

### Laravel 9 - Vehicle Ordering App - test-driven TDD
**sail up -d**

**npm install && npm run dev**

**localhost:1000**

**php artisan make:test Post:test**

**php artisan test**

---
Guidelines
- https://jsdecena.medium.com/simple-tdd-in-laravel-with-11-steps-c475f8b1b214
- https://www.honeybadger.io/blog/laravel-tdd/
- https://laravel.com/docs/9.x/http-tests
- https://laravel.io/articles/building-an-api-using-tdd-in-laravel

---
PHPUnit Cheat Sheet
https://gist.github.com/loonies/1255249
---
**Issues**
1. If you face this problem 


    (could not find driver (SQL: PRAGMA foreign_keys = ON;))
Run this command

`sudo apt-get install php-sqlite3`

2. Another problem
`  ! warning → No tests found in class "Tests\Feature\PostTest".`

Then add annotation

`/** @test */`


