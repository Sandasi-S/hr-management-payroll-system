# HR Management & Payroll System

A web-based HR Management and Payroll System built with Laravel, designed to streamline employee management, attendance tracking, leave approval, and payroll processing for organizations.

**Final Year Project – BSc (Hons) in Information Systems Engineering**

---

## 📋 Overview

This system automates core HR functions including employee records, daily attendance, leave requests with an approval workflow, and automatic payroll calculation based on attendance data — reducing manual paperwork and improving accuracy for HR departments.

## 🎯 Features

### Authentication & Access Control
- Secure login/registration (Laravel Breeze)
- Role-based access control (Admin, Employee)
- Middleware-protected routes

### Employee Management
- Add, view, edit, and deactivate employee records
- Auto-generated login accounts linked to employee profiles
- Department, designation, and salary tracking

### Attendance Management
- Daily attendance recording (Present / Absent / Late)
- Duplicate-entry prevention (one record per employee per day)
- Check-in / check-out time tracking

### Leave Management
- Employees can apply for Sick, Annual, or Casual leave
- Admin approval/rejection workflow
- Overlapping leave request prevention
- Locked editing once a request is approved or rejected

### Payroll Management
- Automatic salary calculation:  
  `Net Salary = Basic Salary + Allowances - Deductions - No-Pay Deduction`
- No-pay deduction automatically calculated from attendance records
- Duplicate payroll prevention (one record per employee per month)
- Payslip-style detailed view

### Admin Dashboard
- Real-time statistics (total employees, pending leaves, today's attendance)
- Monthly payroll cost summary
- Quick access to all modules

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 (PHP 8.2) |
| Frontend | Blade, Tailwind CSS, Alpine.js |
| Database | MySQL |
| Authentication | Laravel Breeze |
| Build Tool | Vite |

## 📂 Project Structure