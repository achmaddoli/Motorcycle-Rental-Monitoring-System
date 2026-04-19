# 🏍️ IoT-Based Remote Monitoring & Control System for Motorcycle Rentals

<p align="center">
  <img src="https://img.shields.io/badge/Platform-Internet_of_Things-blue?style=for-the-badge" alt="Platform">
  <img src="https://img.shields.io/badge/Framework-Laravel-red?style=for-the-badge&logo=laravel" alt="Framework">
  <img src="https://img.shields.io/badge/Hardware-Arduino_Mega-orange?style=for-the-badge&logo=arduino" alt="Hardware">
</p>

## 📌 Project Overview
A professional-grade IoT ecosystem built to solve security vulnerabilities in the motorcycle rental industry. This project integrates a high-precision hardware module with a web-based dashboard, enabling fleet owners to track, monitor, and remotely control vehicles in real-time. 

**This project was developed in collaboration with a local rental partner in Palembang and has been validated through scientific publication.**

---

## 🚀 Key Features
- **📍 Live Tracking:** Real-time geospatial monitoring using Ublox NEO-6M.
- **🛡️ Polygon Geofencing:** Advanced boundary detection using the **Ray Casting Algorithm** for 100% Palembang city area accuracy.
- **🔌 Remote Kill-Switch:** Automated engine immobilization via Relay modules during theft attempts or geofence breaches.
- **🤖 Telegram Bot Integration:** Instant push notifications for rental expiration and security alerts.
- **📊 Admin Control Center:** A centralized Laravel dashboard to manage fleets, users, and rental logs.

---

## 🧠 Comprehensive Reasoning (The "Why")

### **The Problem: Structural Vulnerabilities**
Motorcycle rentals face two "silent killers": **Large-scale embezzlement** and **manual management gaps**.
- **Real Threat:** Recent cases (Jan 2025) showed 20 units stolen by one fraudster, causing ~Rp400M in losses  (Humas Polres Bantul, 2025).
- **Operational Gap:** Manual logging results in zero real-time visibility, leading to delayed returns and untraceable theft.

### **The Research: Beyond Basic Tracking**
Standard circular geofencing is imprecise for urban use. My research focuses on **strict, administrative-based boundaries** to provide the high-level security that rental businesses actually require.

### **The Solution: Why Polygon & Remote Control?**
1. **Precision Logic:** Used **Polygon Geofencing (Ray Casting Algorithm)** to follow the exact administrative borders of Palembang City—far more accurate than standard radii.
2. **Proactive Intervention:** Integrated a **Remote Kill-Switch (Relay)**. The system doesn't just monitor; it automatically immobilizes the engine if a boundary breach or time expiration occurs.
3. **Automated Ecosystem:** Integrated **Laravel, APIs, and Telegram** to replace manual workflows with a seamless, real-time alert and control system.

### Real-World Impact
- **Accuracy:** Proven GPS deviation of only **12.10 meters**.
- **Efficiency:** Reduced manual monitoring workload by **100%** through automated logic triggers.

---

## 🤝 Collaboration & Partnership
This system was field-tested in collaboration with **[Tulis Nama Mitra Kamu Disini]**, a local motorcycle rental business. 
- **Field Test Goal:** To ensure hardware durability and GPRS connectivity reliability in high-mobility urban scenarios.
- **Result:** Successful integration and real-time intervention capabilities during active rental periods.

---

## 📚 Scientific Publication
The methodology and technical implementation of this project have been peer-reviewed and published:
- **Title:** "Rancang Bangun Sistem Monitoring dan Kontrol Jarak Jauh pada Rental Motor Berbasis IoT dengan Geofencing"
- **Journal:** JATI : Jurnal Mahasiswa Teknik Informatika
- **Status:** Published (2025)
- **🔗 [https://doi.org/10.36040/jati.v9i5.14983 ]**

---

## 🛠️ Tech Stack
| Category | Tools & Technologies |
| :--- | :--- |
| **Hardware** | Arduino Mega 2560, SIM7000G (LTE/GSM), Ublox NEO-6M, Relay, Buzzer |
| **Backend** | Laravel (PHP), MySQL |
| **Geospatial** | QGIS, Geopandas (Python), Ray Casting Algorithm |
| **Frontend** | Bootstrap 5, JavaScript, Leaflet.js (Maps) |

---

## 📺 Visuals & Simulation

### Hardware & Software Showcase
<p align="center">
  <img src="path/to/your/dashboard-screenshot.png" width="48%" alt="Dashboard Monitoring">
  <img src="path/to/your/hardware-photo.png" width="48%" alt="Hardware Implementation">
</p>

### Full System Simulation
[![Watch Simulation](https://img.shields.io/badge/Youtube-Watch_Demo_Video-red?style=for-the-badge&logo=youtube)](LINK_VIDEO_YOUTUBE_KAMU)
*Click the badge above to see the hardware trigger, engine cut-off, and Telegram alerts in action.*

---

## 📈 Learning Journey
Building this "End-to-End" system sharpened my skills in **Systems Thinking**. I learned to bridge the gap between physical hardware and cloud-based software, while managing the complexities of real-time geospatial data processing.

---

