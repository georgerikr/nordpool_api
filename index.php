<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elektri börsihind</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="container">
        <div class="component">
            <h3>NordPool EE current stock market price - <span id="current-time"></span></h3>
            <p id="current-stock-price"></p>
            <p id="next-stock-price"></p>
            <form id="alert_sum" method="POST" class="alert">
                <p>Sisestage jooksva tunni hind, mille ületades Teid teavitatakse:</p>
                <div class="form-group">
                    <input type="text" name="price_limit" class="form-control" placeholder="€/MWh" aria-label="Hoiatuse summa" required >
                    <button type="button" onclick="submitAlertSum()" class="send_btn" aria-label="Saada">Saada</button>
                    <p class="alertmsg"><span id="user-limit"></span></p>
                </div>
            </form>
            <h4 class="alertmsg"><span id="limit-alert"></span></h4><br>
            <p id="day-ahead-price"></p>
        </div>
    </div>

    <script>
        // Get user set limit on page refresh, if it's stored in session
        function checkLimit() {
            $.ajax({
                url: 'api/limit/',
                method: 'GET',
                success: function(response) {
                    $('#user-limit').text(response.message);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
        checkLimit();

        // Get current date and time
        function updateClock() {
            $.ajax({
                url: 'api/date_time/',
                method: 'GET',
                success: function(response) {
                    $('#current-time').text(response.date_time_EE);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching current time:', error);
                }
            });
        }
        updateClock();
        setInterval(updateClock, 60 * 1000);

        // Get current stock prices
        function updateCurrentStockPrices() {
            $.ajax({
                url: 'api/current/',
                method: 'GET',
                success: function(response) {
                    $('#current-stock-price').text(response.message);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching current stock:', error);
                }
            });
        }
        updateCurrentStockPrices();
        setInterval(updateCurrentStockPrices, 60 * 1000);

        // Get next hour stock prices
        function updateNextStockPrices() {
            $.ajax({
                url: 'api/next/',
                method: 'GET',
                success: function(response) {
                    $('#next-stock-price').text(response.message);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching next stock:', error);
                }
            });
        }
        updateNextStockPrices();
        setInterval(updateNextStockPrices, 60 * 1000);

        // Get day-ahead stock prices
        function updateDayAheadPrices() {
            $.ajax({
                url: 'api/dayahead/',
                method: 'GET',
                success: function(response) {
                    $('#day-ahead-price').empty();
                    // Iterate over each data object in the response
                    response.forEach(function(data) {
                        // Extract fields from each data object
                        var timestamp = data.timestamp;
                        var priceMwh = data.price_mwh;
                        var priceKwh = data.price_kwh;

                        // Create a new paragraph element with the data
                        var paragraph = $('<p>').text(timestamp + " - " + priceMwh + "€/MWh - " + priceKwh + "€/kWh");

                        // Append the paragraph to the container
                        $('#day-ahead-price').append(paragraph);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching day-ahead:', error);
                }
            });
        }
        updateDayAheadPrices();
        setInterval(updateDayAheadPrices, 15 * 60 * 1000);

        // Get alert message 
        function updateAlert() {
            $.ajax({
                url: 'api/price_limit/',
                method: 'GET',
                success: function(response) {
                    $('#limit-alert').text(response.message);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching price limit:', error);
                }
            });
        }
        updateAlert();
        setInterval(updateAlert, 60 * 1000);

        // Post users limit and get alert for that limit
        function submitAlertSum() {
            var form = $('#alert_sum');
            var formData = form.serialize();
            $.ajax({
                url: 'api/price_limit/',
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#user-limit').text(response.message);
                    updateAlert();
                },
                error: function(xhr, status, error) {
                    console.error('Error posting user limit:', error);
                }
            });
        }

    </script>
</body>
</html>