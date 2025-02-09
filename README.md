# Art Nest - Online Art Gallery Management System

Art Nest is a web-based platform that facilitates the seamless connection between artists, curators, and art enthusiasts. It provides a virtual gallery experience where users can browse, order, and manage artworks, while artists can showcase their creations and interact directly with users. The system also features comprehensive tools for administrators to manage the platform effectively.

## Overview

The project aims to create a user-friendly digital platform for the art community. It supports artist registration, artwork uploads, user browsing and ordering, and provides tools for efficient administration. The platform includes a live chat feature to enable direct communication between users and artists.

## Features

- **User Roles and Permissions:**
  - Separate roles for admin, artists, and users with distinct permissions.
  
- **Artist Registration and Approval:**
  - Artists can register and submit their profiles for approval by the admin.
  - Admin reviews and approves artist profiles before they become active.

- **Art Upload and Management:**
  - Artists can upload their artworks, manage their portfolio, and track their sales.
  - Admin can manage the artwork database, including approvals and deletions.

- **User Browsing and Ordering:**
  - Users can browse artworks by various artists and place orders.
  - The system includes an order tracking feature for users to monitor their purchases.

- **Order Management and Ratings:**
  - Admin can manage all orders placed on the platform.
  - Users can rate artists, and the average ratings are displayed on artist profiles.

- **Live Chat Between Users and Artists:**
  - Users can directly communicate with artists through a built-in chat feature.
  - Messages are stored in the database and displayed in real-time.

- **Admin Dashboard and Analytics:**
  - Admins can view and manage all activities on the platform.
  - The dashboard includes analytics for user engagement, sales, and artist performance.



## Technologies Used

- **PHP:** The core programming language used for backend logic.
- **MySQL:** Relational database management system used for storing application data.
- **HTML/CSS:** For building the application's front-end interface.
- **JavaScript:** For adding interactivity to the web pages.
- **AJAX:** For handling asynchronous requests, especially in the chat feature.


## File Structure

- **index.php:** The main landing page for the application.
- **db_connect.php:** Script for establishing database connections.
- **admin_dashboard.php:** Admin dashboard interface.
- **artist_dashboard.php:** Artist dashboard interface.
- **user_dashboard.php:** User dashboard interface.
- **chat.php:** Script handling the live chat feature.


## Installation

1. Clone the repository.
2. Set up the MySQL database using the provided SQL queries.
3. Configure `db_connect.php` with your database credentials.
4. Paste the project folder into the `htdocs` directory of your local server (e.g., XAMPP, WAMP).
5. Open your web browser and type `http://localhost/your-folder-name` in the address bar to access the application.
6. Run the application on a local server by navigating to the root directory.

## Usage

- **Admin:** Log in via `admin_login.php` to access the admin dashboard.
- **Artist:** Register via `artist_registration.php` and wait for admin approval.
- **User:** Browse artworks and place orders via `home.php`.
- **Live Chat:** Users can start a chat with artists directly from the artist's profile page.
