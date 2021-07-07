<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## About the project

This is a very simple, but fully working currency conversion app made with Laravel and Vue.js
- Backend uses external API service for fetching all currency pairs and conversion rates
- Frontend has a `currency-converter` component that provides instant currency conversions for around 170 supported currency pairs.

## Setting the project up
- Clone the repo
- Make sure to do `composer install` and `npm install` to install front end libraries
- Create a database and name it however you want
- create an `.env` file inside the project root folder and copy over the contents of the `.env.example` to it, then update database
  information to match your own in the `.env` file.
- Run `php artisan key:generate` to generate app key
- Run `php artisan migrate` in the CLI to migrate DB tables
- Change the `apiUrl` property of `AppConfig` object to the correct API url of your own backend inside of `resources/js/bootstrap.js` file.
The code block looks like this 
  ```
    window.AppConfig = {
        apiUrl: 'http://currency-converter.test/api/v1/'
    }
  ```
- Compile all the assets with `npm run dev`.
- You would need to run the Command that actually fetches current currencies and their exchange rates once before using the app
  (since the app requires them in order to function). To do this, the easiest way possible would be just to run `php artisan currency:refresh-rates`
  inside of the CLI. This command can be run in the same away, whenever you want to update currencies and their rates (it's been scheduled
  to run every 6 hours by default - read 'Project defaults' section for more info on this)
- If you want a real time compilation as you work and make front end changes, run `npm run watch`

## Project defaults
- Project is made with a thought in mind that the best way to fetch currencies and conversion rates is to have a Command class that does this
and the command is ran by a CRON job every X hours (you can change this in order to update conversion rates more often). By default, Command is ran
  every 6 hours.
- There is only a need to setup one specific CRON job directly on the server where the app will live in it's final form in order to run
all of the defined CRON commands by the app. In order to find out how to do this, make sure to read through this documentation page 
  https://laravel.com/docs/8.x/scheduling#running-the-scheduler

## Possible improvements
- Caching the currency and currency rates results fetching from the DB and clearing the cache key whenever the CRON command is ran successfully
so that next time it actually fetches newest rates in the controller
- Checking if input in the currency conversion is string and setting the value to 0 if it is for example.
- On the Vue.js side, occasionally do a fetch of possible newest rates from the backend if in the meantime they have changed to make sure
frontend remains up-to-date with newest rates even if page remains open for hours without refreshing.
