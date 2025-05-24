# 🧑‍💻 Softzino HRMS

A modern HRMS (Human Resource Management System) built with Laravel and Docker using Laravel Sail. This project follows a modular architecture with package based modularization and is designed to be scalable and developer-friendly.

---

## 🚀 Project Setup Guide

Follow the steps below to get the project running locally.

---

## 🛠 Requirements

- Docker & Docker Compose
- Node.js & NPM
- Composer

---

## 📦 Installation

### 1. Clone the Repository

```bash
git clone git@github.com:softzino/st-hrms.git st-hrms
cd st-hrms
```

### 2. Copy `.env` File
```bash
cp .env.example .env
```

### 3. Install Composer Dependencies
```bash
composer install
```
### 4. Install NPM Dependencies
```bash
npm install
```
### 5. Start Sail Containers
```bash
./vendor/bin/sail up -d
```
### 6. Generate Application Key
```bash
./vendor/bin/sail artisan key:generate
```

### 7. Run Migrations
```bash
./vendor/bin/sail artisan migrate
```

### 8. Seed the Database (Optional)
```bash
./vendor/bin/sail artisan db:seed
```

### 9. Run the Application Frontend
```bash
npm run dev
```

### 10. Access the Application
```bash
http://localhost
```
