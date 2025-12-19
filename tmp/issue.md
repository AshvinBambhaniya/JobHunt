# Feature: Implement Job Application Reminder System with Push Notifications

## Description
We need a comprehensive reminder system to help users track their job applications. This system will allow users to set manual reminders (e.g., for interviews) and will also generate automated follow-up reminders for applications that have been idle. Users should be alerted via in-app notifications and browser push notifications.

## Core Features
- **Manual Reminders**: Users can create custom reminders linked to specific job applications.
- **Auto-Reminders**: The system automatically suggests follow-ups for applications pending for >7 days.
- **Notifications**:
    - **In-App**: A notification bell showing unread alerts and a dedicated history page.
    - **Browser Push**: Native browser notifications for immediate alerts.
- **Management**: Ability to view, dismiss, and delete reminders.

## Technical Architecture

### Database
- New `reminders` table with:
    - `user_id` & `job_application_id` (FKs)
    - `type` (manual, auto_follow_up, interview)
    - `message`, `scheduled_at`, `status` (pending, sent, dismissed)

### Backend Logic
- **Controller**: `ReminderController` for CRUD operations.
- **Notification**: `JobReminderNotification` (Database channel).
- **Automation**:
    - `reminders:send`: Scheduled command to check pending reminders and trigger notifications.
    - `reminders:generate-auto`: Scheduled command to find stale applications and create follow-up reminders.

### Frontend
- **UI**: Add reminder form on Job Application detail view.
- **Navigation**: Add notification bell with unread count badge.
- **JS Integration**: Implement a JavaScript poller to fetch unread notifications and trigger `new Notification()` API for browser alerts.

## Implementation Checklist

- [ ] **Database Setup**
    - [ ] Create `Reminder` model and migration.
    - [ ] Define Enums for `ReminderType` and `ReminderStatus`.
    - [ ] Update `User` and `JobApplication` models with relationships.

- [ ] **Backend Development**
    - [ ] Implement `ReminderController` (store, destroy).
    - [ ] Create `JobReminderNotification` class.
    - [ ] Create `NotificationController` for listing and marking read.
    - [ ] Develop `reminders:send` Artisan command.
    - [ ] Develop `reminders:generate-auto` Artisan command.
    - [ ] Schedule commands in `routes/console.php`.

- [ ] **Frontend Development**
    - [ ] Add "Add Reminder" form to `show.blade.php`.
    - [ ] Add Notification Bell to global navigation (`app.blade.php`).
    - [ ] Create Notifications Index page (`notifications/index.blade.php`).
    - [ ] Implement JS polling logic for real-time badge updates and browser notifications.

- [ ] **Testing & Verification**
    - [ ] Write Feature tests (`ReminderTest`).
    - [ ] Verify timezone handling (IST).
    - [ ] verify browser notification permissions.
