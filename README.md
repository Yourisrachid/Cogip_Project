# Cogip Project

The Cogip Project is the work and collaboration of backend and frontend developpers who worked together to create a web application which offers companies and their invoices management features.

##### Backend :

- Creation of a RESTful API
- MySQL database management
- CRUD features
- Authentification and roles management

##### Frontend :

- Creation of a modern and responsive interface
- Integration and usage of the RESTful API
- Client side validation

## Table des matières

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Features](#features)
- [Working Team](#working-team)
- [Technologies](#technologies)

## Installation

1. Clone the repository
    ```bash
    git clone git@github.com:Yourisrachid/Cogip_Project.git
    ```
2. Access to the project folder
    ```bash
    cd 'Folder name'
    ```
3. Install dependancies
    ```bash
    composer install
    ```

## Configuration

1. Change the **./Models/DatabaseManager.php** file and update the variables :

	`DB_USERNAME` `DB_PASSWORD`
    ```bash
	Line 18 :             $this->bdd = new PDO('mysql:host=localhost;dbname=cogip;charset=utf8', 'root', 'root');
Change root into your Database Username and Password
    `root` ->` ... `
	`root` ->` ... `
    ```

2. Open the server :

	`Inside your project folder :`
    ```bash 
	 php -S localhost:8000 -t public
    ```

3. (Optional) Execute seeders to fill database with fake informations :

	`URL`
    ```bash
    localhost:8000/seed-companies
	localhost:8000/seed-contacts
	localhost:8000/seed-invoices
    ```

## Usage

1. Access the application [http://localhost:8000](http://localhost:8000) in your navigator. ( The server should still be open )

## Features

- Companies management
- Contacts management
- Invoices management
- Users management
- Roles management

## Working Team

#### Backend

- [Adrien B.](https://github.com/AdrienCopy)
	-	 Routing Setup
	-	 API Creation : Invoices
	-	 API Creation : Authentification
	-	 API Creation : Roles permissions
- [Youris R.](https://github.com/Yourisrachid)
	-	 API Creation : Companies
	-	 API Creation : Contacts
	-	 API Creation : User / Roles Management

#### Frontend

- [Justine F.](https://github.com/Justine-Frigo)
	-	 SQL File Setup
	-	 ALL front related features
	-	 Link between front and back
	-	 Installation of seeders for testing purposes


## Technologies

#### Backend :

- PHP
- MySQL

#### Frontend :

- HTML/SCSS
- JavaScript
- Vue.js

#### Other :

- [Composer](https://getcomposer.org/ "Composer")
- [Bramus Router](https://github.com/bramus/router "Bramus Router")
- [Filp Whoops](https://github.com/filp/whoops "Filp Whoops")
- [FakerPHP(Seeder)](https://fakerphp.org/ "FakerPHP(Seeder)")
