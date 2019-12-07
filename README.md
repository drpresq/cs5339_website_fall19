# CS5339 FALL19 ASSIGNMENT 3
## Table of Contents
- [Assignment 3](#cs5339-fall19-assignment-3)
  - [Table of Contents](#table-of-contents)
    - [Description](#description)
    - [Installation](#installation)

### Description
Repository for CS5339 Fall 2019 Assignment 3

- Assignment Repository consists of the following:
  * Docker-Compose definition for the following service bundle:
    - PHP 7.2
    - SQL 5.7
    - PHP MyAdmin
    - Redis
  * PHP Source files located in `./www/`
  * SQL Source files located in `./SqlImports/`

### Installation

Clone this repository on your local computer, install docker, and `docker-compose up -d`.

    ```
    git clone https://github.com/camaron182/cs5339_fall19_assignment3.git
    cd cs5339_fall19_assignment3/
    ./docker-install.sh
    cp sample.env .env
    docker-compose up -d
    ```
You can access PHPMyAdmin via `http://localhost:8080` where you can import the following files from the management console:
* carparts.sql
* database_definition.sql