## 📌 Project Info

🕒 Made in **40 hours** for [iTec 2025](https://itec.ro/) as **Team EREG**  
🔗 [View on LinkedIn](https://www.linkedin.com/feed/update/urn:li:activity:7318222754334310401)

---


# 📚 Studentious

**Studentious** is a web application built to facilitate collaborative learning through group study sessions. The platform enables users to create, discover, and participate in educational events.

---


## 🚀 Features

- **Study Event Management**: Create, browse, and join group study sessions  
- **User Profiles**: Personalized dashboard and profile customization  
- **Authentication System**: Secure login and registration  

---

## 🛠️ Tech Stack

- **Framework**: Laravel (PHP)  
- **Frontend**: Blade templating with Tailwind CSS
- **Database**: MySQL  
- **Authentication**: Laravel Breeze  

---

## 📋 Requirements

- PHP 8.0+  
- Composer  
- Node.js & NPM  
- MySQL/MariaDB  

---

## 🔧 Installation

1. Clone the repository  
   ```bash
   git clone https://github.com/lluca1/studentious.git
   cd your-repo
   ```

2. Install PHP dependencies:  
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:  
   ```bash
   npm install && npm run build
   ```

4. Copy the example environment file and configure it:  
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Set up your database in `.env`, then run the migrations:  
   ```bash
   php artisan migrate
   ```

6. Create a symbolic link to make storage publicly accessible:  
   ```bash
   php artisan storage:link
   ```

7. (Optional) Seed the database with test data:  
   ```bash
   php artisan db:seed
   ```

8. Start the development server:  
   ```bash
   php artisan serve
   ```

9. Visit the app at http://localhost:8000

