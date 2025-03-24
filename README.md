
## Project Management

**Application that handles the management of companies, projects, users and their data. And a bunch of useful information about their operation.**



## Installation
There is a docker-compose.yml file and can be up and running in no time with `docker-compose up`.

1) **`composer install`**
2) **`npm-install`
3)**`bash ./vendor/bin/sail up`**
4)**`npm-run-dev`** 
5)**`bash ./vendor/bin/sail artisan migrate:fresh --seed`**
   [//]: # "Comment" : Because it is Sail we must give the appropriate format in our commands that's why we make the artisan through bash. If we make it just plain `php artisan` it won't work.

## Architecture

### Back-End

#### The Project uses Domain principals with Sub-Domains and Controller-Service handle for pattern. Details:

> #### <u>Domain: </u> <br>
>> **Company** <br>

> #### <u>Sub-Domains </u> 
>> **Projects, Users**
>
>  #### <u>Value Objects</u>
>> *Helper object for strict guidance's 

> #### <u>Infrastructure:</u> <br>
>> **Events + Notifications + Services** and everything else of program mechanic related. <br>

>  #### <u>Casts + Listeners </u>
>> **Casts + Listeners** </br>
> 
>> <u>Casts:</u> Mutators and Accessors of a value object </br>
>> <u>Listeners:</u> Events Listeners.




    




