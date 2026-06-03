# Pokemon info api

Simple Laravel API application for managing banned Pokemons and fetching Pokemon information from PokeAPI.

---

## Table of Contents

- [About](#about)
- [Tech Stack](#tech-stack)
- [Requirements](#requirements)
- [Installation](#installation)
- [Environment Variables](#environment-variables)
- [Database Setup](#database-setup)
- [Running the Project](#running-the-project)
- [API Documentation](#api-documentation)

---

## About



---

## Tech Stack

- PHP 8.x
- Laravel 13
- SQLite
- Composer

---

## Requirements

Before running the project, make sure you have installed:

### Required

- PHP >= 8.x
- Composer

---

## Installation

Clone repository:

```bash
git clone https://github.com/RafalBytniewski/pokemon-info-api.git
cd pokemon-info-api
```

Install dependencies:

```bash
composer install
```

Create environment file:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

---

## Environment Variables

Configure `.env` file.

### Required

```env
SECRET_KEY: 'your secret key'
```

---

## Database Setup

Run migrations:

```bash
php artisan migrate
```

---

## Running the Project

Run backend server:

```bash
php artisan serve
```

Application available at:

```txt
http://127.0.0.1:8000
```

---

## API Documentation

### Base URL

```txt
http://localhost:8000/api
```

### Endpoints

#### Get banned pokemons

**Request**

```txt
GET /banned
```

**Headers**

```txt
- X-SUPER-SECRET-KEY: your_secret_key
- Content-Type: application/json
```

**Body**
``` json
-
```

**Example Response**

```json
{
    "data": [
        {
            "id": 7,
            "name": "pikachu",
            "created_at": "2026-06-01T03:10:17.000000Z",
            "updated_at": "2026-06-01T03:10:17.000000Z"
        }
    ]
}
```

#### Add banned pokemon

**Request**
```txt
POST /banned
```

**Headers**
```txt
- X-SUPER-SECRET-KEY: your_secret_key
- Content-Type: application/json
```

**Body**
``` json
{
    "name": "Charizard"
}
```

**Example Response**

```json
{
    "message": "Pokemon added to banned",
    "data": {
        "name": "charizard",
        "updated_at": "2026-06-03T03:59:57.000000Z",
        "created_at": "2026-06-03T03:59:57.000000Z",
        "id": 8
    }
}
```

#### Delete banned pokemon

**Request**

```txt
DELETE /banned
```

**Headers**

- X-SUPER-SECRET-KEY: your_secret_key
- Content-Type: application/json

**Body**

```json
{
  "name": "pikachu"
}
```

**Example Response**

```json
{
    "message": "Deleted Succesfully"
}
```

#### Get pokemon info

**Request**
```txt
GET /pokemon
```

**Headers**

- X-SUPER-SECRET-KEY: your_secret_key
- Content-Type: application/json

**Body**

```json
{
    "pokemons": ["pikachu", "snorlax", "Medcham", "Porygon "]
}
```

**Example Response**

```json
{
    "data": [
        {
            "pokemon": "pikachu",
            "message": "Pokemon pikachu is banned"
        },
        {
            "name": "snorlax",
            "height": 21,
            "weight": 4600
        },
        {
            "name": "medcham",
            "error": "Pokemon not found"
        },
        {
            "name": "porygon",
            "height": 8,
            "weight": 365
        }
    ]
}
```
---