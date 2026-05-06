# Weather Insight - PHP/MySQL on XAMPP

## Quick Setup (3 Steps)

### 1. Start XAMPP
- Open **XAMPP Control Panel**
- Start **Apache** and **MySQL**

### 2. Run Database Setup
Open your browser and go to:
```
http://localhost/Weather%20Insight/php/setup.php
```
This will automatically:
- Create the `weather_insight` database
- Create all required tables (users, districts, weather_data, submissions, events, etc.)
- Insert 38 Tamil Nadu districts
- Create default users with hashed passwords

### 3. Open the App
```
http://localhost/Weather%20Insight/frontend/login.html
```

**Login Credentials:**
| Role  | Username | Password |
|-------|----------|----------|
| Admin | AIDS     | AIDS123  |
| User  | ECE      | ECE123   |

---

## Project Structure

```
Weather Insight/
├── database/
│   └── weather_insight.sql      ← Full MySQL schema
├── php/
│   ├── config.php               ← DB credentials & API keys
│   ├── db.php                   ← PDO database class + helpers
│   ├── setup.php                ← One-click DB installer
│   └── api/
│       ├── auth.php             ← Login/logout/session management
│       ├── weather.php          ← Weather API proxy + MySQL caching
│       ├── districts.php        ← District CRUD + weather history
│       ├── submissions.php      ← User weather data submissions
│       ├── events.php           ← Weather alerts & events
│       └── activity.php         ← Activity log management
├── frontend/
│   ├── php-api.js               ← JS API layer connecting to PHP backend
│   ├── auth.js                  ← Updated auth (PHP backend + fallback)
│   ├── login.html               ← Login page (connects to PHP)
│   ├── index.html               ← Main dashboard
│   ├── dashboard.html           ← Dashboard view
│   ├── tamilnadu.html           ← Tamil Nadu weather view
│   └── ... (all other CSS/JS unchanged)
└── backend/
    └── app.py                   ← Original Flask backend (kept for reference)
```

## PHP API Endpoints

### Authentication
| Method | URL | Description |
|--------|-----|-------------|
| POST   | `/php/api/auth.php?action=login` | Login with username/password/role |
| POST   | `/php/api/auth.php?action=logout` | Logout (invalidate session) |
| GET    | `/php/api/auth.php?action=check` | Check if session is valid |
| GET    | `/php/api/auth.php?action=setup` | Create/update default users |

### Weather Data (OpenWeatherMap → MySQL cache)
| Method | URL | Description |
|--------|-----|-------------|
| GET    | `/php/api/weather.php?action=current&city=Chennai` | Current weather |
| GET    | `/php/api/weather.php?action=forecast&city=Chennai` | 5-day forecast |
| GET    | `/php/api/weather.php?action=insights&city=Chennai` | AI-powered insights |
| GET    | `/php/api/weather.php?action=air_quality&city=Chennai` | Air quality index |
| GET    | `/php/api/weather.php?action=health` | API health check |

### Districts
| Method | URL | Description |
|--------|-----|-------------|
| GET    | `/php/api/districts.php?action=list` | All districts |
| GET    | `/php/api/districts.php?action=get&name=Chennai` | Single district + weather |
| GET    | `/php/api/districts.php?action=weather_history&district=Chennai&days=7` | Historical data |
| GET    | `/php/api/districts.php?action=latest_weather` | Latest weather for all districts |
| GET    | `/php/api/districts.php?action=regions` | List regions |

### Submissions
| Method | URL | Description |
|--------|-----|-------------|
| GET    | `/php/api/submissions.php?action=list` | List all submissions |
| POST   | `/php/api/submissions.php?action=create` | Submit weather data |
| PUT    | `/php/api/submissions.php?action=review&id=1` | Approve/reject (admin) |
| DELETE | `/php/api/submissions.php?action=delete&id=1` | Delete submission |
| GET    | `/php/api/submissions.php?action=stats` | Submission statistics |

### Events (Alerts)
| Method | URL | Description |
|--------|-----|-------------|
| GET    | `/php/api/events.php?action=active` | Active weather alerts |
| POST   | `/php/api/events.php?action=create` | Report weather event |
| PUT    | `/php/api/events.php?action=update&id=1` | Update event (admin) |
| DELETE | `/php/api/events.php?action=delete&id=1` | Delete event (admin) |

### Activity Log
| Method | URL | Description |
|--------|-----|-------------|
| GET    | `/php/api/activity.php?action=list` | View activity log |
| DELETE | `/php/api/activity.php?action=clear` | Clear log (admin) |

## MySQL Tables

| Table | Purpose |
|-------|---------|
| `users` | User accounts with hashed passwords |
| `user_sessions` | Session tokens for authentication |
| `districts` | 38 Tamil Nadu districts with coordinates |
| `weather_data` | Cached weather API data (historical) |
| `weather_submissions` | User-submitted weather observations |
| `weather_events` | Weather alerts and incidents |
| `forecast_cache` | Cached forecast data |
| `api_cache` | Generic API response cache |
| `activity_log` | User activity tracking |

## Configuration

Edit `php/config.php` to change:
- Database credentials (default: root/no password for XAMPP)
- OpenWeatherMap API key
- Cache duration
- Session duration
