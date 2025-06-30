# 🩺 MediDesk - Clinic Appointment Management System

A modern single-page application for managing clinic appointments, built using **Laravel 11**, **Vue 3**, **Inertia.js**, and **Tailwind CSS**.

## 🚀 Features

- 👤 User Authentication (Login/Register)
- 📝 Add new appointments
- 🔄 Avoid time conflicts with 30-min slot logic
- ✅ Mark appointments as complete
- ❌ Cancel/delete appointments
- 📅 Sort by date & time (ascending)
- 💨 SPA experience with Inertia.js

## 📸 Screenshots

> *(You can add a few screenshots here)*

## 🛠️ Tech Stack

- **Backend:** Laravel 11
- **Frontend:** Vue 3 + Inertia.js
- **Styling:** Tailwind CSS
- **Database:** MySQL / SQLite

## 🧪 Setup Instructions

```bash
git clone https://github.com/your-username/clinic-appointment-app.git
cd clinic-appointment-app

cp .env.example .env
composer install
npm install && npm run dev

php artisan key:generate
php artisan migrate
