# Overview 
Laravel + ReactJS web application for quickly fetching tv shows next episode data. Powered by TVMaze free API.

UI only in lithuanian language.

# Installation
* Run 
    >composer install
* Copy `.env.eample` and rename to `.env`
* Configure `.env` with site and database information
* Run
    >php artisan key:generate

    >php artisan migrate

# Setup
* Go to `/register` and register an account
* Manually change `role` to 5 for the in your database to give admin role
* Go to `/admin`, navigate to `Settings` and set canRegister to `false` to block further registration attempts
* Navigate to `Shows` in admin panel and add some shows to display on frontend

    