
# TABLEO 1

## Overview
This project is built using PHP and Laravel. The versions used are:
- **PHP Version:** 8.1
- **Laravel Version:** 9

## Prerequisites
Before you begin, ensure you have met the following requirements:
- You have installed PHP 8.1 or higher.
- You have installed Composer.
- You have installed Node.js and npm.

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/your-username/your-repository.git
   cd your-repository
   ```

2. **Install dependencies:**
   ```sh
   composer install
   npm install
   ```

3. **Set up environment variables:**
   - Copy the `.env.example` file to `.env`:
     ```sh
     cp .env.example .env
     ```
   - Open the `.env` file and configure your environment variables (e.g., database connection settings).

4. **Generate application key:**
   ```sh
   php artisan key:generate
   ```

5. **Run database migrations:**
   ```sh
   php artisan migrate
   ```

6. **Build frontend assets (tailwind):**
   ```sh
   npm run dev
   ```

## Running the Application

1. **Start the development server:**
   ```sh
   php artisan serve
   ```

2. Open your browser and visit `http://localhost:8000` to see the application.


## License
This project is open source and available under the [MIT License](LICENSE).
