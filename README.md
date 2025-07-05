## Inventory & Financial Reporting System

### Overview

### Requirements

- PHP >= 8.2
- Composer
- Laravel 12
- MySQL
- Node.js and NPM (for frontend assets)

### Installation

1. Clone the Repository

```bash
    git clone <repository-url>
    cd inventory
```
2. Install PHP Dependencies

```bash
    composer install
```
3. Install JavaScript Dependencies

```bash
    npm install
```
4. Set Up Environment
- Copy the .env.example file to .env:

```bash
    cp .env.example .env
```
- Generate an application key:
```bash
    php artisan key:generate
```