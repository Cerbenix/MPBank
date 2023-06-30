<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# MPBank

## Description

This is a bank simulation site using mainly Laravel 8 with some Alpine.js and TailwindCSS for the frontend.

Feature included:

1. User authentication, login with Google2FA, QR code available on profile page after registering.
2. Account creation/deletion - debit or investment with a wide range of currencies.
3. Account information pages - history, current investments etc.
4. Ability to make transfers with 2 factor authentication.
5. Currency conversion depending on receiver/sender account currencies. [Freecurrencyapi](https://coinmarketcap.com/api/documentation/v1/)
6. Ability to purchase and sell investments from a long list of cryptocurrencies. [Coinmarketcap API](https://freecurrencyapi.com/docs)

## Project Setup

#### Install
``
composer install
``

``
npm install
``

#### Setup .env file

``
cp .env.example .env
``

You will need to setup the database connection and add your own api keys.

#### Create database

``
php artisan migrate
``

#### Run project locally

``
php artisan serv
``

In case you want to make frontend changes open a new terminal and use

``
npm run watch
``

#### For additional project setup info

[Here](https://devmarketer.io/learn/setup-laravel-project-cloned-github-com/) is a good step by step guide of setting up a cloned laravel project.

## Take a look

### Register/Login
![image](https://github.com/Cerbenix/MPBank/assets/124684938/2add981f-e803-437b-a5d7-552fa32718c7)

![image](https://github.com/Cerbenix/MPBank/assets/124684938/c4701885-6a4e-4b80-b3cd-452385c53edf)

### Account list
![image](https://github.com/Cerbenix/MPBank/assets/124684938/969f6240-f9b8-488e-8402-2543470e2253)

### Account info
![image](https://github.com/Cerbenix/MPBank/assets/124684938/ca0ab880-da39-44a4-92c9-37d832380488)

### Transfer form
![image](https://github.com/Cerbenix/MPBank/assets/124684938/1c5b5ad6-212e-42ef-bd45-c1ce37391de5)

### Investment options
![image](https://github.com/Cerbenix/MPBank/assets/124684938/d0a7e9a2-8834-4a45-abc9-e089c7590a1c)

### Investment purchase
![image](https://github.com/Cerbenix/MPBank/assets/124684938/f7ad775a-5f34-492a-9e09-50af0b4bec4f)


