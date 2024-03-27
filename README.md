Hello, Piyush here. The project is to create a `Laravel` and `Vue.js` currency converter web application.

# Problem statement
Build a web application that allows user to get currency conversion rates against USD. The user should be able to select up to five currencies for which the conversion rates will be displayed.

User should be able to submit a report request to get historical conversion rates between USD and one more currency. This report will be generated by a background job that runs every 15 minutes. Once the report is generated, the job will appear as completed on the user home page where it can be viewed in tabular form.


# Approach

My approach for this implementation was to create an app with basic UI and showcase as much of my laravel and vue js experience as possible. I broke down the tasks into different deliverables.

## User authentication
For authentication, I used the default authentication page built by `Inertia`. The authentication middleware has been added to the routes created in this project.

## Get latest exchange currency rates

My focus on this problem was to focus on front-end using vue.js and create components that would interact with each other. I used pinia store to manage states across the components and also validate the number of currency codes that can be selected.

For backend, I created a simple route that would fetch the live rates externally and respond it to the front-end. There is no storage involved. Quite a few tests have been added for this route with mock responses and also used model factories for unit testing.

## Get historical exchange rates

For historical exchange rates, my focus was majorly on backend functionalities. The implementation includes creating a date range for the historical rates in the backend, adding the job to the batch, and consuming the batch through schedular that runs every fifteen minutes. 

I created a table to store all the historical rates so that for report generation, the number of requests sent to API is reduced. The idea is to first search local database for historical rates, and if the rates do not exist for that currency for that period, then add the job to batching to get historical rates from external which stores into our local database for future retrieval. With this, the user will be able to get the historical rates instantenously on front-end.

I created a basic UI and provided limited components in front-end. If the currencies has been added to the queue for batching, then the batch ID is received to the front-end which shows the progress of the batch to the user.


# Installation

1. Initialise this repo on local machine
2. Run `composer install` to install dependencies. The project uses `laravel v10.x` and `vue.js v3`
3. Create an account and get API key for currency exchange rates from https://freecurrencyapi.com 
3. Setup `.env` file from `.env.example` and add the retrieved API to `CURRENCY_LAYER_API_KEY` parameter. **PLEASE FOLLOW THIS STEP BEFORE RUNNING MIGRATIONS**
4. Run database migrations and create tables with `php artisan migrate`
5. Install node dependencies with `npm install`
6. Compile JavaScript assets with `npm run dev`
7. To run scheduler, use command `php artisan schedule:run`, where the queued job will be consumed every fifteen minutes. Alternatively, for immediate consuming of jobs, use `php artisan queue:work`
8. Run the laravel app with `php artisan serve`

The endpoint for the live currency rates app is `{url}/currencies` and for the conversion history rates is `{url}/historical-rates`. There is no navigation added so it need to navigated manually

**Note:** https://currencylayer.com wouldn't let me allow to use APIs end-points for free and was forcing me to upgrade to paid membership, so instead I used https://freecurrencyapi.com which allowed me to use upto 5k requests per month for free.


# Future potential

The app is missing navigation pages and needs lot more UI refinement. My objective was to focus on the core concepts of the app and hence relied on bootstrap for beautification.

The authentication can be designed and improved with custom middleware for more functionality.

The requests are not validated currently as there are not many parameters being sent by front-end for validation and models do not have any relations.

Lastly, apart from unit tests, front-end tests can be added by using front-end testing frameworks like cypress.

