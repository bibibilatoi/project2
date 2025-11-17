## Register page:
### Introduction:
- We created a page called **register.php** which is used for creating new management accounts.
- It cannot be access through typing the URL link in the address bar. This is because the register is intended for mangers only so it shouldn't be accessed through URL and only through a trusted page like manager login. 
- However, we do realized that in real world practice, there shouldn't be an register page in the first place and any admin/manager register is done internally.
- We didn't implement the prevent URL access for login.php, however. The main reason is we forgot and didn't have time to do it.
### How it works:
#### A. Creating new accounts:
1. The user filled out the form in the register.php page
2. The form is processed by manage_process_register.php:
	  - The username + email is checked to prevent duplicate accounts
	  - The password is validated (9 characters long and include uppercase, lowercase, number, and special character)
3. If the form passed the check then the data is inserted to the database (manager table)
4. Finally after data insertion, the page is redirect to the login page.

#### B. Preventing direct URL access:
1. The login.php submit a form with a token if the "link" to register page is clicked:
```php
<!--- Form to go to register page with a correct token --->
<form class="Tranfer_to_register" action="register.php" method="POST">
	<input type="hidden" name="access_via_login" value="<?php echo $_SESSION['reg_token']; ?>">
	<label>Don't have an account?</label>
	<button type="submit">Click here</button>
</form>
```


2. The register.php page check the accessed method and check the token:
```php
if ($_SERVER['REQUEST_METHOD'] !== 'POST' ||
    !isset($_POST['access_via_login'], $_SESSION['reg_token']) ||
    $_POST['access_via_login'] !== $_SESSION['reg_token']
){
    unset($_SESSION['reg_token']);
    die("Access Denied!");
}
```


## Login access with password:

### Introduction:
- We check the login with password and username from the database.
- We also implemented a timeout if too much wrong attempts.
### How it works:

#### A. Attempts check:
```php
$name = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$success = false; // Flag to track success/failure for unified cleanup


if (!isset($_SESSION['login_attempts'])) {
	$_SESSION['login_attempts'] = 0;
	$_SESSION['last_attempt_time'] = 0;
}

// Check if user needs to wait before trying again
if ($_SESSION['login_attempts'] >= 3) {
	$delay = min(5 * $_SESSION['login_attempts'], 30); // 5s, 10s, 15s, capped at 30s
	$time_since_last = time() - $_SESSION['last_attempt_time'];
	if ($time_since_last < $delay) {
		$wait = $delay - $time_since_last;
		$_SESSION['login_error'] = "Too many failed attempts. Please wait {$wait} seconds before trying again.";
		$conn->close();
		header("Location: login.php");
		exit();
	}
}
```
#### B. Login check:
1. The username and password is sent from login.php to manage_process_login.php
2. The password is checked with accounts in the database:
```php
$stmt = $conn->prepare("SELECT username, email, password FROM managers WHERE username = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
	$user = $result->fetch_assoc();

	if (password_verify($password, $user['password'])) {
		$success = true;
		$_SESSION['login_attempts'] = 0;
		$_SESSION['last_attempt_time'] = time();
		$_SESSION['username'] = $user['username'];
		$_SESSION['email'] = $user['email'];
	}
}
```



## Apply form security:
### Introduction:
- The security method here is the same as the token method above.
- We use a token to prevent bot spamming form submission
- We also validate errors server side with process_eoi.php and send back the errors as a list to display in the apply page
- For convenience, we store user old inputs in a list/array in case of form validation have errors
- If the form is correct, we forward and echo back the form as a table in confirm_eoi.php 
- All of these pages: process_eoi, confirm_eoi are guarded using tokens
- Lastly, the confirm_eoi page form can be refreshed multiple time to prevent the user accidentally clicking refresh and missed the table. However, the multiple refresh is allowed only in a small time frame of 60 seconds.

### How it works:
#### A. Old input stored and Form validation:
```php
//if error exist, save input and error and go back to apply
if (!empty($errors)) {
    //Save the entire submitted data for re-generation
    $_SESSION['apply_form_data'] = $_POST;
    
    $_SESSION['apply_errors'] = $errors;
    $conn->close();
    header("Location: apply.php");
    exit;
}
```

Retrieving errors and old inputs in apply.php:
```php
$general_error = $_SESSION['apply_error'] ?? '';
unset($_SESSION['apply_error']);

// Retrieve validation errors
$validation_errors = $_SESSION['apply_errors'] ?? [];
unset($_SESSION['apply_errors']);
// Retrieve old form data to re-genarate the form
$old_input = $_SESSION['apply_form_data'] ?? [];
unset($_SESSION['apply_form_data']);
```


#### B. Confirm page with multiple refresh in a set time frame:
1. If the form submitted is correct, we remember the current time to later check the refresh time frame (in process_eoi.php): `$_SESSION['eoi_confirm_time'] = time();`
2. Then, each time the confirm page is refreshed, we check the time:
```php
// Define the maximum viewing time (seconds) 
// After the time expire, if refresh the page or change the url then the page cant be accessed
$MAX_VIEW_TIME = 60; 

//Check for explicit finish
if (isset($_POST['finish'])) {
    unset($_SESSION['eoi_confirm']);
    unset($_SESSION['eoi_confirm_time']); 
    header("Location: apply.php");
    exit;
}

//Check remaining time left
$is_expired = false;
if (isset($_SESSION['eoi_confirm_time']) && (time() - $_SESSION['eoi_confirm_time']) > $MAX_VIEW_TIME) {
    $is_expired = true;
}
// If access is denied or time out -> clear any lingering session keys
if (!isset($_SESSION['eoi_confirm']) || $is_expired) {
    unset($_SESSION['eoi_confirm']);
    unset($_SESSION['eoi_confirm_time']); 
    header("Location: apply.php");
    exit;
}

```
