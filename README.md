# 🚗 License Plate Recognition (LPR) System

This project is a **License Plate Recognition (LPR) System** built with **Laravel, YOLO (vehicle detection), OpenCV, and EasyOCR**.  
It supports **resident and non-resident vehicle management**, automatic **transaction recording**, and integrates with **OBS (Open Broadcaster Software)** for virtual camera input.

---

## 📦 Installation

1. Clone this repository:
   ```bash
   git clone https://github.com/yourusername/lpr-system.git
   cd lpr-system
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install && npm run dev
   ```

3. Set up `.env` file:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configure your database connection in `.env`, then run:
   ```bash
   php artisan migrate --seed
   ```

---

## 🔑 Default Login

- **Email:** `admin@gmail.com`  
- **Password:** `abc123`

---

## 🚀 Usage Guide

### 1. Login
- Go to the login page.
- Use the default credentials above.

### 2. Register Resident
- Navigate to the **Residents** tab.
- Register a new resident:
  - **Name:** `test`  
  - **Phone:** `0123456789`  
  - **Plate Number:** `MDF9984`  

### 3. Setup OBS Virtual Camera
1. Open **OBS Studio**.
2. Add a **Media Source**.
3. Select the video located at:
   ```
   lpr-system/public/assets/dist/python/video/new.mp4
   ```
4. Resize the video to **fit the screen width**.
5. Start the **Virtual Camera** in OBS.

### 4. Start Scanning
1. Go to the **Scan** tab in the LPR system.
2. A **Windows popup camera window** will appear.
3. Wait for the system to detect the license plate.

### 5. Check Transactions
- If the scan is successful, the result will appear in the **Transactions** table.

---

## 📂 Project Structure

- `app/Models` → Laravel models for users, residents, non-residents, transactions  
- `database/migrations` → Migrations for all tables  
- `database/seeders` → Seeder for default admin user  
- `public/assets/dist/python/video/` → Demo videos for scanning  

---

## ⚙️ Requirements

- PHP 8.3+
- MySQL 8+
- Composer
- Node.js & NPM
- OBS Studio (for virtual camera input)
- Python (for YOLO & OCR integration)

---

## ✨ Features

- ✅ Resident & Non-Resident management  
- ✅ License Plate Recognition using YOLO & EasyOCR  
- ✅ OBS Virtual Camera integration  
- ✅ Transaction history logging  
- ✅ User authentication with roles  

---

## 👤 Author

**Muhammad Mursyid Bin Arbain**  
Bachelor of Computer Science (Hons.) – UiTM Cawangan Melaka Kampus Jasin  

---

## 📝 License

This project is for **educational purposes** and can be adapted for real-world implementations.
