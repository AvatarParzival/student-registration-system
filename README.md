# Student Registration System

![XAMPP Compatible](https://img.shields.io/badge/XAMPP-Compatible-brightgreen)
![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)
![MySQL Ready](https://img.shields.io/badge/MySQL-5.7%2B-orange)

A secure, responsive **student management system** with a modern UI, designed to work seamlessly with **XAMPP**.

---

## 🌟 Features
- **One-Click XAMPP Setup**
- **Mobile-First Responsive Design**
- **Real-Time Form Validation**
- **CSRF Protected Forms**
- **Interactive Student Dashboard**

---

## 🛠️ Installation (XAMPP)

### 1️⃣ Install XAMPP
Download and install the latest version:  
[https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)

---

### 2️⃣ Setup Project
```bash
# Clone repository or download as Zip
git clone https://github.com/yourusername/student-registration-system.git

# Move to XAMPP's htdocs:
# Windows:
move student-registration-system C:\xampp\htdocs\

# macOS/Linux:
mv student-registration-system /opt/lampp/htdocs/
```

---

### 3️⃣ Start Services
Launch **XAMPP Control Panel** and start:
- Apache
- MySQL

<p align="center">
  <a href="#">
    <img src="https://i.ibb.co/zWw92Zmx/Screenshot-2025-08-13-065303.jpg" alt="Screenshot" />
  </a>
</p>

---

### 4️⃣ Database Setup

#### Method 1 — SQL Command
1. Open phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)  
2. Run:
```sql
CREATE DATABASE internship_db;
```
3. Import `database.sql` from the project folder.

#### Method 2 — phpMyAdmin Interface
1. Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin)  
2. Click **"New"** in the left sidebar.  
3. Enter `internship_db` as the **Database Name**.  
4. Click **Create**.  
5. Select the newly created database from the left panel.  
6. Go to the **Import** tab.  
7. Choose the `database.sql` file from your project folder.  
8. Click **Go** to import.

---

### 5️⃣ Configure Database
Edit `includes/db.php`:
```php
<?php
$server = 'localhost';
$user = 'root';     // Default XAMPP username
$pass = '';         // Default XAMPP password
$db   = 'internship_db';
```

---

### 6️⃣ Launch Application
Access in browser:  
[http://localhost/student-registration-system/index.html](http://localhost/student-registration-system/index.html)

---

## 📸 Screenshots
| Registration Form | Student Dashboard |
|-------------------|-------------------|
| <a href="https://imgbb.com/"><img src="https://i.ibb.co/Q3rpcN7G/Screenshot-2025-08-13-073000.jpg" border="0"></a> | <a href="https://imgbb.com/"><img src="https://i.ibb.co/DgvfH25N/Screenshot-2025-08-13-073514.jpg" border="0"></a> |

---

## 🖥️ Technologies

| Component  | Technology Stack |
|------------|------------------|
| Frontend   | Tailwind CSS, Vanilla JS |
| Backend    | PHP 8+ |
| Database   | MySQL |
| Security   | CSRF Tokens, Prepared Statements |

---

## 🚨 Troubleshooting

| Issue | Solution |
|-------|----------|
| Connection errors | Verify MySQL is running in XAMPP |
| Page not loading | Check files are in `htdocs` folder |
| Form submission fails | Ensure Apache is running |
| Database issues | Re-import `database.sql` |

---

## 📂 Project Structure
```
student-registration/
├── api/
│   └── toggle.php
├── app.js
├── csrf.php
├── database.sql
├── db.php
├── delete_student.php
├── index.html
├── register.php
├── style.css
└── view_student.php

```

---

## 🔒 Security Features

**Double-Layer Protection:**
```php
// CSRF Example
if (!isset($_SESSION['csrf']) || $_POST['csrf'] !== $_SESSION['csrf']) {
    die("Security violation detected");
}
```

**SQL Injection Prevention:**
```php
$stmt = $conn->prepare("INSERT INTO students VALUES(?,?,?,?)");
$stmt->bind_param("ssss", $name, $email, $roll, $dept);
```

---

## 💡 Pro Tips
- **Enable Debug Mode** (in `db.php`):
```php
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
```
- **Create Database Backup**:
```bash
mysqldump -u root -p internship_db > backup.sql
```
- **Use Virtual Host for cleaner URLs**:
```
127.0.0.1 studentapp.local
```

---

## 🤝 Contributing
1. Fork the repository  
2. Create a new branch:
```bash
git checkout -b feature
```
3. Commit changes:
```bash
git commit -m 'Add feature'
```
4. Push to branch:
```bash
git push origin feature
```
5. Open a Pull Request

---
