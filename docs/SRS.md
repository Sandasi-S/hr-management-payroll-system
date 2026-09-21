# Software Requirements Specification (SRS)
## HR Management & Payroll System

**Project Type:** Final Year Project (BSc Information Systems Engineering)  
**Prepared by:** Sandasi Samaranayaka  
**Date:** September 2026

---

## 1. Introduction

### 1.1 Purpose
This document specifies the software requirements for the HR Management & Payroll System, a web-based application designed to automate core human resource functions including employee record management, attendance tracking, leave approval, and payroll processing.

### 1.2 Scope
The system enables organizations to:
- Manage employee records digitally
- Track daily attendance
- Process leave requests through an approval workflow
- Automatically calculate employee salaries based on attendance
- Generate downloadable payslips
- View real-time HR statistics via an admin dashboard

### 1.3 Intended Audience
- HR Administrators / Managers (primary users)
- Employees (secondary users, future scope)
- System developers and academic evaluators

### 1.4 Definitions
| Term | Definition |
|---|---|
| RBAC | Role-Based Access Control |
| CRUD | Create, Read, Update, Delete |
| No-Pay Day | A day an employee was absent without approved leave, resulting in salary deduction |

---

## 2. Overall Description

### 2.1 Product Perspective
The system is a standalone web application built using the Laravel framework (PHP), with a MySQL database, following the MVC (Model-View-Controller) architectural pattern.

### 2.2 User Classes
| Role | Permissions |
|---|---|
| Admin | Full access: manage employees, attendance, leaves, payroll, view dashboard |
| Employee | Login access (future scope: view own attendance/leave/payslip) |

### 2.3 Operating Environment
- Server: Apache (via XAMPP for development)
- Database: MySQL
- Browser-based frontend (responsive, Tailwind CSS)

### 2.4 Assumptions
- One organization/company instance per system deployment
- Monthly payroll cycle (not bi-weekly or weekly)
- 30-day standard month used for per-day salary calculation

---

## 3. Functional Requirements

### FR1: Authentication & Access Control
- FR1.1: Users must register/login with email and password
- FR1.2: Passwords must be securely hashed (bcrypt)
- FR1.3: System must restrict access based on user role (Admin only for management modules)
- FR1.4: Unauthorized access attempts must return a 403 error

### FR2: Employee Management
- FR2.1: Admin can add a new employee (creates linked login account + employee profile)
- FR2.2: Admin can view a list of all employees
- FR2.3: Admin can edit employee details
- FR2.4: Admin can delete an employee (cascades to related records)
- FR2.5: Employee code must be unique

### FR3: Attendance Management
- FR3.1: Admin can record daily attendance (Present/Absent/Late)
- FR3.2: System must prevent duplicate attendance entries for the same employee on the same date
- FR3.3: Admin can view, edit, and delete attendance records

### FR4: Leave Management
- FR4.1: Leave requests can be submitted with type (Sick/Annual/Casual), date range, and reason
- FR4.2: System must prevent overlapping leave requests for the same employee
- FR4.3: Admin can approve or reject pending leave requests
- FR4.4: Approved/rejected leave requests cannot be edited or deleted
- FR4.5: System records which admin approved/rejected each request

### FR5: Payroll Management
- FR5.1: System automatically calculates net salary using the formula:
  `Net Salary = Basic Salary + Allowances - Deductions - No-Pay Deduction`
- FR5.2: No-pay deduction is calculated automatically from "Absent" attendance records in the selected month
- FR5.3: System must prevent duplicate payroll generation for the same employee/month
- FR5.4: Admin can mark payroll as "Paid"
- FR5.5: System generates a downloadable PDF payslip

### FR6: Admin Dashboard
- FR6.1: Dashboard displays total active employees
- FR6.2: Dashboard displays pending leave request count
- FR6.3: Dashboard displays today's attendance summary (present/absent)
- FR6.4: Dashboard displays current month's total payroll cost
- FR6.5: Dashboard lists recent pending leave requests for quick review

---

## 4. Non-Functional Requirements

### 4.1 Security
- All passwords stored using one-way hashing (bcrypt)
- Role-based middleware protects all management routes
- CSRF protection on all forms (Laravel built-in)

### 4.2 Usability
- Responsive UI (Tailwind CSS) usable on desktop and tablet
- Clear success/error feedback messages for all actions

### 4.3 Performance
- Dashboard statistics load within 2 seconds under normal data volume

### 4.4 Reliability
- Data integrity enforced via database foreign key constraints and unique indexes (e.g., no duplicate attendance/payroll/leave overlaps)

### 4.5 Maintainability
- Codebase follows Laravel MVC conventions for ease of future extension
- Version controlled using Git/GitHub

---

## 5. System Architecture

The system follows the **MVC (Model-View-Controller)** pattern:
- **Model:** Eloquent ORM classes (Employee, Attendance, Leave, Payroll, User) representing database tables and relationships
- **View:** Blade templates rendering the UI
- **Controller:** Handles business logic (validation, calculations, CRUD operations)

**Architecture diagram:** 3-tier (Presentation → Application Logic → Database)

---

## 6. Database Design (Summary)

| Table | Key Fields | Relationships |
|---|---|---|
| users | id, name, email, password, role | 1:1 with employees |
| employees | id, user_id, employee_code, department, basic_salary | 1:many with attendances, leaves, payrolls |
| attendances | id, employee_id, date, status | belongs to employees |
| leaves | id, employee_id, leave_type, status, approved_by | belongs to employees, users (approver) |
| payrolls | id, employee_id, month, net_salary, status | belongs to employees |

*(Full ER diagram to be added as an image in `docs/diagrams/`)*

---

## 7. Use Cases (Summary)

| Use Case | Actor | Description |
|---|---|---|
| Manage Employees | Admin | Add, view, edit, delete employee records |
| Record Attendance | Admin | Log daily attendance per employee |
| Apply for Leave | Employee/Admin | Submit leave request |
| Approve/Reject Leave | Admin | Review and decide on pending leave requests |
| Generate Payroll | Admin | Auto-calculate and generate monthly payroll |
| Download Payslip | Admin | Generate PDF payslip for an employee |

*(Full use case diagram to be added as an image in `docs/diagrams/`)*

---

## 8. Future Enhancements
- Employee self-service portal (view own attendance/leave/payslip)
- Email notifications for leave approval/rejection
- Multi-company support
- Overtime and bonus calculation