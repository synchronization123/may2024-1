Sure, here's the modified `login.html` and `login.php` files:

**login.html:**

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

**login.php:**

```php
<?php
// Retrieve username and password from POST request
$username = $_POST['username'];
$password = $_POST['password'];

// Your login logic here, for example:
if ($username === 'example_user' && $password === 'example_password') {
    // Successful login
    $response = "Login successful!";
} else {
    // Failed login
    $response = "Invalid username or password!";
}

// Send response message back to login.html
echo $response;
?>
```

In these files, `login.html` remains the same with AJAX handling the form submission and displaying the response message without redirecting. `login.php` has been modified to handle the login logic and return the response message back to `login.html`. Make sure to replace `<web_server_B_domain_or_IP>` and `/path_to_login.php` with the actual domain or IP address of web server B and the path to `login.php` respectively.