# **MyBookingRewards Tech Test (Take 2)**

To run this you will need to have installed NPM, Docker and Composer on your machine.

Please do the following...

Pull master branch from repo - https://github.com/dannyrowlands/mbr2

Navigate to root of the project then
* Copy .env.mbr to .env by running `cp .env.example .env` (_**All settings have been pre-filled for you**_)
* Run `composer install`
* Run `npm install`
* Run `npm run build`
* Run `./vendor/bin/sail up -d` (_**Allow time for newly built Sail Docker image to fully come up before issuing next command. Will fail with MySQL error if you don't**_.)
* Run `./vendor/bin/sail artisan migrate`
* Run `./vendor/bin/sail artisan db:seed`

Navigate to http://localhost

You should then see the project page and be able to fill in form.
