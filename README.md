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
---