# 📸 Camagru

<div align="center">
  <img src="sources/public/assets/logo.webp" alt="Camagru Logo" width="120">
  <h3>Interactive photobooth-style web application for photo editing and sharing</h3>
  <p><strong>42 Barcelona Common Core Project</strong></p>
</div>

---

## 📖 Project Overview

**Camagru** is a full-featured web platform that allows users to capture live photos directly from their webcam (or upload images from their device), overlay real-time configurable stickers and frames, and publish their creations to a public interactive gallery where registered users can like and comment.

The project is built around a custom **MVC architecture**, following robust security best practices (protection against SQL injection, XSS, CSRF, secure password storage using bcrypt hashing) and delivering a reactive, seamless user experience powered by **Vanilla JavaScript (AJAX)** and **modern CSS3**.

---

## 🛠️ Tech Stack

| Layer | Technologies | Description |
| :--- | :--- | :--- |
| **Backend** | **PHP 8.2 (FPM)** | Pure PHP with no third-party frameworks or libraries; uses standard library, PDO, and GD extensions for server-side image processing. |
| **Frontend** | **HTML5, CSS3, Vanilla JS** | Modular Native ES Modules, Fetch API, MediaStream API (Webcam), Canvas API, and responsive CSS Grid & Flexbox. |
| **Database** | **MySQL 8.0** | Relational schema with referential integrity, `ON DELETE CASCADE` foreign keys, indexes, and an Event Scheduler for automatic expired token cleanup. |
| **Web Server** | **Nginx (Alpine)** | Fast reverse proxy configured for PHP-FPM FastCGI pass and clean URL routing. |
| **Email Service** | **msmtp** | Lightweight SMTP client configured inside the PHP container for transactional emails (account activation, password reset, and comment notifications). |
| **Deployment** | **Docker & Docker Compose** | Fully containerized, reproducible environment deployable with a single command and persistent database volumes. |

---

## ✨ Key Features

### 👤 1. User Management & Authentication
- **Secure Registration**: Strict server-side and client-side validation for usernames, email format, and password complexity (length, uppercase, lowercase, numbers).
- **Email Verification**: Unique time-limited activation tokens sent via email to verify account ownership before allowing login.
- **Login & "Remember Me"**: Secure authentication supporting persistent sessions with encrypted remember-me tokens stored in HTTP-only cookies.
- **Password Recovery**: Secure password reset flow using single-use expiration tokens sent by email.
- **Fast Logout**: One-click logout accessible from any view across the application.
- **User Profile & Settings**:
  - Update username and email (with confirmation verification for new email addresses).
  - Secure password update requiring current password validation.
  - Avatar upload and management.
  - Real-time user stats (number of uploaded photos, received likes, and received comments).
  - Account deletion ("Danger Zone") with cascading removal of user data, uploaded photos, comments, and likes.

### 🎨 2. Photo Editor (Photobooth)
- **Live Webcam Feed**: Real-time video integration using `navigator.mediaDevices.getUserMedia`.
- **Local File Upload**: Alternative upload support for devices without a camera or for pre-existing pictures.
- **Interactive Sticker Overlay**:
  - Add multiple stickers simultaneously (up to 10 items).
  - Drag-and-drop positioning on top of the image preview.
  - Scale adjustment (0.3x to 2.5x) and rotation controls (-180° to 180°).
  - Individual sticker removal or full canvas reset.
- **Server-Side Image Processing**: Graphical merging executed strictly on the backend using the **PHP GD** library (`imagecopy`, `imagescale`, `imagerotate`, `imagewebp`), ensuring consistent, high-quality results independent of client-side canvas rendering.
- **Sidebar Thumbnail History**: Real-time list of user creations with full-size `<dialog>` preview, direct download options, and instant deletion.

### 🖼️ 3. Public Gallery & Social Features
- **Chronological Feed**: Displays all photos from all users ordered by creation date descending.
- **AJAX Social Interactions**:
  - Instant like/unlike toggle without page reload, including double-tap / double-click like animations.
  - Real-time comment submission and live counter updates.
  - Comment moderation: users can delete their own comments or any comment left on their photos.
- **Email Notifications**: Automatic notification email dispatched to the photo owner when a new comment is posted (enabled by default, customizable in user preferences).
- **Dynamic Pagination**: Progressive photo loading ("Load More") in chunks of 6 items.

---

## 🌟 Bonus Features

- 🌍 **Full Multi-Language Support (i18n)**: UI and server-side responses localized in **English (`en`)**, **Spanish (`es`)**, and **Catalan (`ca`)**.
- ⚡ **100% AJAX Architecture**: All interactive operations (likes, comments, photo uploads, deletions, settings forms) execute asynchronously without full page refreshes.
- 📂 **Private Gallery & Favorites**:
  - Dedicated personal gallery view to manage user-uploaded photos.
  - Favorites section to quickly view liked posts.
- 🎯 **Advanced Sticker Manipulation**: Support for up to 10 concurrent overlays with custom scale and 360° rotation.
- 💾 **Direct Image Download**: Interactive modal allowing users to inspect and download high-resolution WebP images.

---

## 🚀 Getting Started

### Prerequisites
- [Docker](https://docs.docker.com/get-docker/) (v20+)
- [Docker Compose](https://docs.docker.com/compose/)
- [Make](https://www.gnu.org/software/make/)

### 1. Clone the repository
```bash
git clone https://github.com/adrmarqu/camagru.git
cd camagru
```

### 2. Configure Environment Variables
Copy the example environment file and configure your credentials:
```bash
cp .env.example .env
```

Edit `.env` with your settings:
```env
# Database Credentials
DB_HOST=db
DB_NAME=camagru
DB_USER=camagru_user
DB_PASSWORD=camagru_password
DB_ROOT_PASSWORD=camagru_root_password

# SMTP Mail Settings (e.g. Gmail App Password)
MAIL_USER=your_email@gmail.com
MAIL_PASSWORD=your_app_password

# Base Application URL
APP_URL=http://localhost
```

*(Optional)* If you wish to access via the local domain `http://camagru.42barcelona`, add the following entry to your `/etc/hosts`:
```text
127.0.0.1 camagru.42barcelona
```

### 3. Start the Containers
Build and run all services in detached mode:
```bash
make
```
Or directly with Docker Compose:
```bash
docker-compose up -d --build
```

### 4. Access the Application
- **Web App**: [http://localhost](http://localhost) (or `http://camagru.42barcelona`)
- **phpMyAdmin**: [http://localhost:8080](http://localhost:8080) (for database inspection)

---

## 📜 Makefile Commands

| Command | Description |
| :--- | :--- |
| `make` / `make up` | Builds images and starts all containers in detached mode. |
| `make down` | Stops and removes containers and networks. |
| `make restart` | Restarts all active containers. |
| `make status` | Displays container status (`docker-compose ps`). |
| `make logs` | Streams live logs from all services. |
| `make clean` | Stops containers and cleans orphaned network resources. |
| `make fclean` | Deep clean: removes containers, networks, and **database data volumes**. |
| `make re` | Performs `fclean` followed by `up` for a fresh start. |
| `make open` | Opens the web application in your default browser. |
| `make chrome` | Opens the web application in Google Chrome. |
| `make fire` | Opens the web application in Mozilla Firefox. |
| `make db` | Opens the phpMyAdmin interface in your default browser. |

---

## 📁 Project Structure

```text
camagru/
├── Dockerfile                  # PHP image build with GD, PDO, and msmtp
├── docker-compose.yml          # Service orchestration (Nginx, PHP, MySQL, phpMyAdmin)
├── Makefile                    # Environment management rules
├── README.md                   # Project documentation
├── .env.example                # Example environment variables template
├── entrypoint.sh               # PHP container startup & msmtp configuration script
├── nginx/
│   └── conf.d/default.conf     # Nginx FastCGI reverse proxy configuration
└── sources/
    ├── config/
    │   └── init.sql            # Database schema, indexes, foreign keys, and scheduler
    ├── public/                 # Web root directory (DocumentRoot)
    │   ├── index.php           # Front Controller and central routing
    │   ├── api/                # AJAX endpoints (upload, like, comment, delete, etc.)
    │   ├── assets/             # Static assets (stickers, logos, icons)
    │   ├── css/                # Stylesheets organized by view and common themes
    │   ├── js/                 # Modular native ES JavaScript scripts
    │   └── uploads/            # User-uploaded images and avatars
    └── app/                    # Application logic (MVC)
        ├── Controllers/        # Request handlers (Auth, Main, Token, Error)
        ├── Core/               # Router, Middleware, Bootstrap, Autoloader, Auth
        ├── Exceptions/         # Custom exception classes (Http, Form, DB)
        ├── Helpers/            # Helper utilities (Mailer, Token, Validate, Navigator)
        ├── Models/             # PDO database models
        ├── Views/              # HTML/PHP view templates and layouts
        └── langs/              # i18n translation dictionaries (en.php, es.php, ca.php)
```

---

## 🔒 Security Measures

1. **SQL Injection Prevention**: 100% of database queries use PDO prepared statements with strict parameter binding (`bindValue`).
2. **Cross-Site Scripting (XSS)**: User input is sanitized and escaped on render using `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`.
3. **Password Security**: Passwords are saved strictly using `password_hash()` with `PASSWORD_DEFAULT` (bcrypt) with adaptive cost; plain text passwords are never stored.
4. **File Upload Security**:
   - MIME type verification and image header validation using `getimagesize()` and `imagecreatefromstring()`.
   - Cryptographically random filenames generated on the server (`bin2hex(random_bytes(16))`).
   - Merging and re-encoding to standardized WebP format to prevent executable payload injection.
5. **Resource Ownership Validation**: Tokenized directory paths per user, and delete operations enforce user ownership check before removing photos or comments.

---

## 👨‍💻 Author

Developed by **Adrià Márquez ([adrmarqu](https://github.com/adrmarqu))** as part of the **42 Barcelona** Common Core cursus.
