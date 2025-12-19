# Implementation Plan: Reminder System with Push Notifications

## Goal
Implement a comprehensive reminder system that includes user-generated reminders, automated system reminders for job follow-ups, and push notifications to alert the user.

## Features
1.  **Manual Reminders**: Users can set custom reminders (e.g., "Interview at 10 AM") linked to specific Job Applications.
2.  **Auto-Reminders**: System automatically schedules reminders for specific events (e.g., "Follow up" 7 days after applying).
3.  **Notifications**:
    *   **In-App**: Notification list (bell icon) showing unread alerts.
    *   **Browser/Push**: Browser-native notifications for due items using the JS `Notification` API.
4.  **Management**: A UI to view, manage, and dismiss reminders.

## Technical Components

### 1. Database & Models
*   **Create `Reminder` Model**:
    *   `user_id` (FK to users)
    *   `job_application_id` (Nullable FK to job_applications)
    *   `type` (enum: 'manual', 'auto_follow_up', 'interview')
    *   `message` (string)
    *   `scheduled_at` (datetime)
    *   `status` (enum: 'pending', 'sent', 'dismissed')
*   **Migration**: Create `reminders` table.

### 2. Backend Logic
*   **Controllers**:
    *   `ReminderController`: Handle CRUD for reminders (store, destroy, mark as read).
*   **Notifications**:
    *   `JobReminderNotification`: A Laravel Notification class. Channels: `['database']`.
*   **Scheduler (The "Push" Engine)**:
    *   Create a Console Command `reminders:send`.
    *   Checks `Reminder` records where `scheduled_at <= now()` and `status == 'pending'`.
    *   Sends `JobReminderNotification`.
    *   Updates `Reminder` status to 'sent'.
*   **Auto-Reminder Generator**:
    *   Create a Console Command `reminders:generate-auto`.
    *   Checks for Job Applications with status 'applied' > 7 days ago with no recent logs.
    *   Creates a `Reminder` entry if one doesn't exist.

### 3. Frontend Implementation
*   **UI Components**:
    *   **Add Reminder Form**: Added to the Job Application details page (`show.blade.php`).
    *   **Notification Bell**: In the navigation bar (`app.blade.php`) showing unread notification count.
    *   **Notifications Page**: A page to view all history.
*   **Browser Push Integration**:
    *   Add a JavaScript poller (using `setInterval` or similar) in `app.js` to check the backend for new unread notifications.
    *   Use the browser's native `new Notification()` API to trigger a desktop alert when a new notification is detected.

### 4. Routes
*   `POST /job-applications/{job_application}/reminders` (Store manual reminder)
*   `DELETE /reminders/{reminder}`
*   `POST /reminders/{reminder}/dismiss`
*   `GET /notifications/unread` (For JS poller)
*   `GET /notifications` (View all)

## Execution Steps
1.  **Scaffold**: Create Model, Migration, and Factory for `Reminder`.
2.  **Logic**: Implement the `ReminderController` and `JobReminderNotification`.
3.  **Automation**: Write the Artisan commands (`reminders:send` and `reminders:generate-auto`).
4.  **UI**: Update the global Layout (Notification bell) and Job Application view (Add Reminder form).
5.  **JS**: Implement the browser notification permission request and polling logic.
