# Fork for Admin-Dash For Laravel 5.4

## Changes

* Added support for APP_NAME in the .env file.
* Added support for Email Confirmation on Registration
    * User is not logged in automatically after completing Registration.
    * User is not allowed to login until confirmation is completed.
    * If User attempts to login, they will get a notification with message containing link to resend confirmation.
    * Confirmation is sent via a broadcast event.
    * Email Confirmation is controlled via REQUIRE_EMAIL_CONFIRMATION=0|1 in the .env file.
* Added support for Social avatars.
    * This is controlled by using USE_GRAVATAR=0 in your .env file.
    * If this is set to 1, then it defaults to the old way using Gravatar.
    * The User table is updated to have an avatar field. This is different from the avatar field in the SocialProviders table (which is the actual url to the remote avatar).
    * Each time the User logs in with their social account, the avatar is updated.
* Added support for Twitter and Google login/registration
* Changed 'resource/views/Emails' to 'resource/views/emails'


# Admin-Dash For Laravel 5.4

Admin-Dash is a start-up template implementing the [Admin LTE](https://almsaeedstudio.com/themes/AdminLTE/index2.html) admin panel into a Laravel 5.4 project.  The starter application is based on the sample application built in [Laravel 5.4 For Beginners](https://leanpub.com/laravel-5-4-for-beginners) by Bill Keck.

![](admin-dash.png)



In addition to the Admin LTE implementation, Admin-Dash also includes Facebook and Github integration through Socialite.  Working datagrids, with pagination, column sorts and search, using Vue.js and various other features found in the [book](https://leanpub.com/laravel-5-4-for-beginners).

If you would like to help support the development of Admin-Dash, there is no donation button, however, contributions can be made by [purchasing the book](https://leanpub.com/laravel-5-4-for-beginners).

## Installation

Follow [the basic instructions](https://help.github.com/articles/fork-a-repo/) for forking a repo from Github.

You will have to create your own .env file for laravel.  You can get an example of a .env from the [master](https://github.com/laravel/laravel/blob/master/.env.example):

~~~~

APP_ENV=local
APP_KEY=generate-your-app-key
APP_DEBUG=true
APP_LOG_LEVEL=debug
APP_URL=http://localhost
APP_NAME=your-app-name

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_DRIVER=log
MAIL_HOST="mailtrap.io"
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=

FACEBOOK_ID=your-facebook-id
FACEBOOK_SECRET=your-facebook-secret
FACEBOOK_URL=http://your-domain.com/auth/facebook/callback

TWITTER_ID=your-twitter-id
TWITTER_SECRET=your-twitter-secret
TWITTER_URL=http://your-domain.com/auth/twitter/callback

GOOGLE_ID=your-google-id
GOOGLE_SECRET=your-google-secret
GOOGLE_URL=http://your-domain.com/auth/google/callback

GITHUB_ID=your-github-id
GITHUB_SECRET=your-github-secret
GITHUB_URL=http://your-domain.com/auth/github/callback

USE_GRAVATAR=0|1
REQUIRE_EMAIL_CONFIRMATION=0|1


~~~~ 

You’ll note it has a blank APP_KEY.  You will need to run the following from the command line:

~~~~

php artisan key:generate

~~~~

The MAIL_DRIVER is set to log, setting up with mailtrap.io is recommended.

You will also need to add your Facebook, Twitter, Google and/or GitHub info to the .env parameters if you wish to use the social logins:

~~~~

FACEBOOK_ID=
FACEBOOK_SECRET=
FACEBOOK_URL=

TWITTER_ID=
TWITTER_SECRET=
TWITTER_URL=

GOOGLE_ID=
GOOGLE_SECRET=
GOOGLE_URL=

GITHUB_ID=
GITHUB_SECRET=
GITHUB_URL=

~~~~

Obviously, you will have to create your Facebook, Twitter, Google and Github apps on your own to supply the credentials.  The starter app does support form-based login and registration, so you don’t need to have Social Logins setup for it to work.

You should also add your DB info in your .env file:

~~~~

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-username
DB_PASSWORD=your-db-password

~~~~

After creating your DB and supplying the credentials, you will need to run from the command line:

~~~~

php  artisan migrate

~~~~

Next, from the command line,  run:

~~~~

npm install

~~~~

To navigate to the admin dashboard, create a user and change their is_admin value to 1 in the database.  This will cause the admin link to appear on the user dash.  Note that admin users are directed to the admin dash upon login.

On the admin panel, check the site pages link for additional pages with working data grids, written in Vue.js.

To use this application, you need a working knowledge of the Laravel framework, with composer installed.  If you are unfamiliar with Laravel, see the [docs](https://laravel.com/docs/5.4).  For those just getting started, check out [Laravel 5.4 For Beginners](https://leanpub.com/laravel-5-4-for-beginners).

## License

Admin-Dash is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
