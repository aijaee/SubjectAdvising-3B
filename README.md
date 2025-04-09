# Subject Advising System

## Features
- Allows students to view available subjects
- Enables advisers to approve or reject student subject selections
- Maintains student academic records and history
- Provides user access based on roles (Student, Adviser, Admin)

## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/aijaee/SubjectAdvising-3B.git
   ```

2. Navigate to the project directory:
   ```bash
   cd SubjectAdvising-3B
   ```

3. Install Laravel dependencies using Composer:
   ```bash
   composer install
   ```

4. Copy the example environment file and configure it:
   ```bash
   cp .env.example .env
   ```

5. Generate the application key:
   ```bash
   php artisan key:generate
   ```

6. Set up your local database:
   - Create a database named `advising_db` in **phpMyAdmin** (or via MySQL CLI).
   - Update the `.env` file with your database configuration:
     ```
     DB_HOST=localhost
     DB_USER=root
     DB_PASS=
     DB_NAME=advising_db
     ```

7. Run migrations (if applicable):
   ```bash
   php artisan migrate
   ```

8. Serve the application:
   ```bash
   php artisan serve
   ```

9. Open your browser and visit:
   ```
   http://localhost:8000
   ```

## Configuration
- Ensure your `.env` file has the following database configuration:
  ```
  DB_HOST=localhost
  DB_USER=root
  DB_PASS=
  DB_NAME=advising_db
  ```

- System requirements:
  - PHP >= 7.3
  - Composer
  - MySQL
  - Laravel framework
  - Node.js v14 or higher (if using frontend assets)
  - Windows 10 / Linux / macOS

## Authors
**BSCS 3B**

- Ang, Francis Miles B.  
- Arante, Irad Joseph S.  
- Besa, Franco Angelo B.  
- Ganza, Nethanea Xznarelle S.  
- Guinalon, Thea Zen M.
