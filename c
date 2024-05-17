Sure, you can achieve this using AJAX to send the form data to `login.php` and then display the response message on `login.html` without redirecting. Here's how you can modify `login.html`:

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('form').on('submit', function(event){
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: 'http://<web_server_B_domain_or_IP>/path_to_login.php',
                    data: formData,
                    success: function(response){
                        $('#login-message').text(response);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <form>
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Submit">
    </form>
    <div id="login-message"></div>
</body>
</html>
```

With this modification, when the user submits the form, it will use AJAX to send the form data to `login.php` on web server B, and the response from `login.php` will be displayed on `login.html` without refreshing or redirecting the page. Make sure to replace `<web_server_B_domain_or_IP>` and `/path_to_login.php` with the actual domain or IP address of web server B and the path to `login.php` respectively.