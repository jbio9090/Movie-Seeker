# Movie Seeker

Movie Seeker is a PHP-based web application that allows users to discover movies using the TMDB (The Movie Database) API. Users can create an account, log in, and curate their own personal watchlist of favorite movies. The application is fully containerized using Docker for easy setup and deployment.

### Features

* **Movie Search:** Search for any movie using the extensive TMDB API.
* **User Authentication:** Secure user registration and login system.
* **Personal Watchlist:** Logged-in users can add and remove movies from their watchlist.
* **Dockerized Environment:** Quick and consistent setup across different environments using Docker.

### Prerequisites

If you want to host it, ensure you have met the following requirements:

* **Docker** and **Docker Compose** installed on your machine.
* **TMDB API Key:** You can get one by registering at [The Movie Database](https://www.themoviedb.org/documentation/api).

---

### Setup and Installation

1. **Clone the repository:**
git clone [https://github.com/yourusername/movie-seeker.git](https://github.com/yourusername/movie-seeker.git)
cd movie-seeker
2. **Configure Environment Variables:**
Create a `.env` file in the root directory (or copy from `.env.example` if available).

```
app_name="Movie Seeker"
app_url="http://localhost:80/"

TMDB_API_KEY=""

db_host="db"
port="3306"
db_name="movieseekerdb"
db_username="root"
db_password="root"

MAILTRAP_API_KEY=""

google_client_id=""
google_client_secret=""
google_redirect_uri=""
```

3. **Build and run the Docker containers:**
docker-compose up -d --build
4. **Database Migration (Importing the SQL file):**
To set up your database tables, use the included Adminer database management tool:
* Open your web browser and go to `http://localhost:8080`.
* Log in using the following credentials:
* **System:** MySQL
* **Server:** db
* **Username:** root
* **Password:** root
* **Database:** movieseekerdb


* Once logged in, click on **SQL Command** or **Import** in the left sidebar.
* Choose or open your project's `.sql` file, and click **Execute** to run the schema migration.


5. **Access the application:**
Open your web browser and navigate to `http://localhost:80`.

---

### Usage

* **Search:** Use the search bar on the homepage to find movies.
* **Register/Login:** Create an account to access watchlist features.
* **Watchlist:** Click the "Add to Watchlist" button on any movie card or details page to save it to your account.