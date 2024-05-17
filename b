Certainly! You can create a login form in `login.html` with fields for username and password, and a submit button. Then, you can configure the form action to point to the `login.php` file on the other web server. Here's an example of how you can structure your files:

1. **login.html** (Located in web server A Django folder):

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form action="http://<web_server_B_domain_or_IP>/path_to_login.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username"><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
```

2. **login.php** (Located in web server B Apache folder):

```php
<?php
// Retrieve username and password from POST request
$username = $_POST['username'];
$password = $_POST['password'];

// Your login logic here, for example:
if ($username === 'example_user' && $password === 'example_password') {
    // Successful login
    echo "Login successful!";
} else {
    // Failed login
    echo "Invalid username or password!";
}
?>
```

Make sure to replace `<web_server_B_domain_or_IP>` and `/path_to_login.php` with the actual domain or IP address of web server B and the path to `login.php` respectively.

This setup allows the login form hosted on web server A to submit user input to the PHP logic hosted on web server B for authentication.