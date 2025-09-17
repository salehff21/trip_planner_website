# trip_planner_website
# 🌍 Trip Planner Website

A PHP & MySQL based tourism planning website that helps users create, manage, and visualize their travel itineraries with ease.  

---

## ✨ Features

- 🗺️ Add and manage destinations (beach, culture, shopping, restaurants, etc.).  
- 📅 Create, edit, and print custom trip plans.  
- 👤 User authentication (login/register).  
- 📂 View and manage all saved plans.  
- 🖼️ Image categories for destinations.  
- 📍 Database-driven design with MySQL.  
- 📲 Responsive layout with custom CSS files.  

---

## 🧰 Tech Stack

| Component   | Technology              |
|-------------|-------------------------|
| Frontend    | HTML, CSS, JavaScript   |
| Backend     | PHP (WAMP)              |
| Database    | MySQL (tourism_db.sql)  |
| Server      | Apache (WAMP stack)     |
| Versioning  | Git + GitHub            |

---

## 📂 Project Structure

```plaintext
trip_planner_website/
├── .vscode/
│   └── launch.json              # VS Code config
├── CSS/                         # Stylesheets
│   ├── style_about.css
│   ├── style_create_plan.css
│   ├── style_edit_profile.css
│   ├── style_home.css
│   ├── style_my_plans.css
│   ├── style_print_plan.css
│   ├── style_view_plan.css
│   ├── style.css
│   ├── stylelogin.css
│   └── styleRegister.css
├── database/
│   └── tourism_db.sql           # MySQL database schema
├── image/
│   ├── categories/              # Destination categories
│   │   ├── beach.jpg
│   │   ├── culture.jpg
│   │   ├── restaurant.jpg
│   │   ├── shopping.jpg
│   │   ├── waterfall.jpg
│   │   └── ...
│   └── City.jpg
├── includes/
│   ├── db.php                   # Database connection
│   ├── header.php               # Common header
│   └── navbar.php               # Navigation bar
├── uploads/                     # Main PHP pages
│   ├── about.php
│   ├── create_plan.php
│   ├── edit_plan.php
│   ├── edit_profile.php
│   ├── generate_plan.php
│   ├── home.php
│   ├── login.php
│   ├── logout.php
│   ├── my_plans.php
│   ├── print_plan.php
│   ├── register.php
│   └── view_plan.php
├── index.html                   # Landing page
└── README.md
