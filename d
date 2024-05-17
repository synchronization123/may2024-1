Certainly! Here's the modified `login.php` code to handle the AJAX request and return a response message:

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

In this modified version, `login.php` checks if the provided username and password match some predetermined values (e.g., 'example_user' and 'example_password'). Depending on the result, it stores the response message in the `$response` variable and echoes it out. This response message will be received by the AJAX request in `login.html` and displayed to the user without redirecting the page.