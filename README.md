# 🥗 Symfony Meal Planner

A smart and flexible meal planning app built with **Symfony** and **Doctrine**, designed to help users manage their recipes, weekly meal plans, and nutritional goals.

---

## 🚀 Features

- 🧾 Create and manage recipes with ingredients, preparation time, calories, and tags
- 📅 Plan meals day-by-day with drag-and-drop support
- 🧠 Smart calorie estimation using BMI
- 🔍 Filter meals by vegetarian, vegan, allergens, and more
- 🛒 Generate shopping lists from planned meals
- 📊 Track personal nutrition metrics (optional BMI form)
- 🖼️ Upload images for recipes
- 🔒 User authentication and admin approval for content

---

## ⚙️ Tech Stack

- **Symfony 7**
- **Doctrine ORM**
- **Twig templating**
- **Bootstrap 5**
- **MySQL**
- **Webpack Encore**

---

## 📦 Installation

1. **Clone the repository:**
git clone https://github.com/yourusername/Symfony_php_mealPlanner.git
cd Symfony_php_mealPlanner
2. **Install PHP dependencies:**
composer install
3. **Install frontend assets (if needed):**
npm install
npm run dev
4. **Set up your .env.local:**
DATABASE_URL="mysql://db_user:db_pass@127.0.0.1:3306/mealitup?serverVersion=8.0"
5. **Create and migrate the database:**
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
6. **Run the Symfony local server:**
symfony server:start
