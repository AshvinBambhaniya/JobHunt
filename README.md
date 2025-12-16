# Job Application Tracker

A robust Laravel 12 application designed to help users track and manage their job search process efficiently. Keep track of applications, log status updates, and monitor your progress in one centralized dashboard.

## Features

-   **User Authentication**: Secure registration and login system.
-   **Application Management**: Create, read, update, and delete job applications.
-   **Status Tracking**: Log detailed history and status changes for each application (e.g., Applied, Interviewing, Offer, Rejected).
-   **Salary Expectations**: Record and track expected salaries for positions.
-   **Job Types**: Categorize applications by job type (Full-time, Contract, etc.).
-   **Responsive Design**: Built with Tailwind CSS for a seamless mobile and desktop experience.

## Tech Stack

-   **Framework**: [Laravel 12](https://laravel.com)
-   **Language**: PHP 8.2+
-   **Database**: MySQL
-   **Cache & Queue**: Redis
-   **Frontend**: Blade Templates, [Tailwind CSS](https://tailwindcss.com), [Vite](https://vitejs.dev)
-   **Containerization**: Docker & Docker Compose

## Prerequisites

Ensure you have the following installed on your local machine:

-   [Docker](https://www.docker.com/) & [Docker Compose](https://docs.docker.com/compose/)
-   [Git](https://git-scm.com/)

## Installation & Setup

### Using Docker (Recommended)

1.  **Clone the repository**
    ```bash
    git clone https://github.com/AshvinBambhaniya/JobHunt
    cd todo-app
    ```

2.  **Build and Start Containers**
    ```bash
    docker-compose up -d --build
    ```
    *This will build the application image with all dependencies and start the services.*

3.  **Database Setup**
    Run the migrations to set up the database schema:
    ```bash
    docker-compose exec app php artisan migrate --force
    ```

4.  **Access the Application**
    Open your browser and visit: `http://localhost:8000`

### Local Development (Without Docker)

If you prefer running PHP and MySQL locally:

1.  Clone the repository.
2.  Install dependencies:
    ```bash
    composer run setup
    ```
    *Note: Ensure your local `.env` file is configured with your local database credentials before the migration step runs, or run the steps manually.*
3.  Start the development server:
    ```bash
    composer run dev
    ```

## Usage

1.  **Register**: Create a new account to start tracking.
2.  **Dashboard**: View your list of active applications.
3.  **New Application**: Click "Add Application" to input details about a new job opportunity (Company, Position, Salary, etc.).
4.  **Log Status**: Update the status of your applications as they progress. The system maintains a log of these changes.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.
