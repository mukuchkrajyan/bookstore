
# Book Reservation System

A simple Laravel-based **Book Reservation API** that demonstrates clean backend architecture, service layer logic, concurrency-safe database operations, and automatic expiration of reservations.

This project is designed primarily for **learning purposes and demonstrating backend engineering best practices**.

---

# Features

- Book reservation API
- API authentication with Bearer tokens
- Prevention of duplicate pending reservations
- Stock validation and concurrency protection
- Reservation expiration mechanism
- Scheduled command for cleaning expired reservations
- Service-oriented architecture
- Event-driven actions

---

# Project Architecture

The project follows a structured Laravel request lifecycle with clear separation of responsibilities:

Route  
↓  
Middleware  
↓  
FormRequest Validation  
↓  
Controller  
↓  
Service Layer (Business Logic)  
↓  
Model / Database Operations  
↓  
Event Dispatch  

This structure separates authentication, validation, business logic, and persistence concerns, making the system easier to maintain and extend.

---

# Authentication

API authentication uses **Bearer Tokens**.

Example request header:

Authorization: Bearer YOUR_API_TOKEN

Middleware used:

- auth
- verified
- api.token
- auth.token

The middleware extracts the token and sets the authenticated user for the request.

---

# API Endpoint

## Create Reservation

POST /api/reservations

Request body:

{
  "book_id": 1,
  "quantity": 2
}

Response:

201 Created

---

# Reservation Flow

Client Request  
↓  
FormRequest Validation  
↓  
ReservationService  
↓  
Database Transaction  
↓  
Reservation Created  
↓  
Event Triggered  

---

# Validation Layer

Validation is handled using:

StoreReservationRequest

Validation rules:

- book_id → required | integer | exists:books,id
- quantity → required | integer | min:1

Additional checks:

- User cannot create multiple **pending reservations** for the same book
- Requested quantity cannot exceed **available stock**

These checks improve **user experience**, but **critical validations are also repeated inside the service layer** to ensure data integrity.

---

# Service Layer

Business logic is handled inside:

ReservationService

Responsibilities:

- Reservation creation
- Stock validation
- Preventing duplicate reservations
- Database transactions
- Event dispatching

---

# Concurrency Protection

The system prevents **race conditions** when multiple reservation requests occur simultaneously.

Example problem:

User A → reserves book  
User B → reserves book at same time  

Without protection both could pass validation and reduce stock incorrectly.

To prevent this the system uses:

DB::transaction()  
lockForUpdate()

Example:

```php
$book = Book::query()
    ->lockForUpdate()
    ->findOrFail($bookId);
```

This locks the database row until the transaction completes.

---

# Reservation Creation Algorithm

1. Start database transaction
2. Lock book row using `lockForUpdate`
3. Validate stock availability
4. Check existing pending reservation
5. Create reservation
6. Decrease book stock
7. Commit transaction
8. Dispatch reservation event

---

# Reservation Expiration

Reservations expire automatically after a configured time.

Configuration:

config/reservation.php

Example:

```php
return [
    'expires_minutes' => 30,
];
```

Usage:

```php
'expires_at' => now()->addMinutes(config('reservation.expires_minutes'));
```

---

# Scheduled Command

Expired reservations are automatically canceled using a scheduled command.

Command:

reservations:cancel-expired

Scheduled in:

routes/console.php

Example:

```php
Schedule::command('reservations:cancel-expired')->everyMinute();
```

The command finds expired reservations and updates their status.

Example logic:

```php
Reservation::where('status', 'pending')
    ->where('expires_at', '<', now())
    ->update(['status' => 'canceled']);
```

---

# Events

When a reservation is successfully created, the system dispatches an event.

Event:

ReservationCreated

Purpose:

- Logging
- Notifications
- Future integrations

Example:

```php
event(new ReservationCreated($reservation));
```

---

# Middleware

The project includes several custom middleware:

- api.token
- auth.token
- redirect.if.admin
- admin

Example use case:

redirect.if.admin

Prevents admin users from accessing the user interface and redirects them to the admin dashboard.

---

# Concurrency Safety

Critical checks are intentionally repeated inside the service layer.

Example:

```php
if ($book->stock < $quantity) {
    throw new RuntimeException('Insufficient stock');
}
```

Even though validation exists earlier, this ensures **data consistency inside transactions**.

---

# Technologies

- Laravel
- MySQL
- Eloquent ORM
- Laravel Scheduler
- Laravel Events
- Service Layer Pattern

---

# Purpose of the Project

This project demonstrates:

- Clean architecture
- Transaction-safe operations
- Event-driven design
- Separation of concerns
- Production-ready backend patterns
