<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <!-- Bootstrap CDN -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.18/vue.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body>
    <div id="currency-app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 currency-list">
                    <currency-codes :all-codes='@json($currencyCodes)'></currency-codes>
                </div>
                <div class="col-lg-6 currency-list">
                    <selected-currencies></selected-currencies>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <exchange-rates></exchange-rates>
            </div>
        </div>
    </div>
    </body>
</html>
