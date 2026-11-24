<?php
declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/**
 * ITCS333 A4 starter — contact form.
 * Requirements (see README rubric):
 *   - GET: render the form
 *   - POST: validate name (required, 2-60 chars), email (valid), message (required, 10-1000 chars)
 *   - invalid POST: re-render with inline errors + repopulated fields (200)
 *   - valid POST: redirect (302/303) to a success page (PRG)
 *   - escape all output with htmlspecialchars
 */

require_once __DIR__ . '/../src/validate.php';

$method = $_SERVER["REQUEST_METHOD"];
$errors = [];

if ($method === "POST") {
    $name = htmlspecialchars($_POST["name"] ?? "");
    $email = htmlspecialchars($_POST["email"] ?? "");
    $message = htmlspecialchars($_POST["message"] ?? "");

    if (!validate_required($name)) {
        $errors["name"] = "Name is required.";
    } else if (!validate_length($name, 2, 60)) {
        $errors["name"] = "Name must be 2 to 60 characters.";
    }

    if (!validate_email($email)) {
        $errors["email"] = "Invalid email.";
    }

    if (!validate_required($message)) {
        $errors["message"] = "Message is required.";
    } else if (!validate_length($message, 10, 1000)) {
        $errors["message"] = "Message must be 10 to 1000 characters.";
    }

    if (!$errors) {
      header("Location: success.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Contact Us</title>
</head>
<body>
  <h1>Contact Us</h1>
  <form method="post" action="index.php">
    <label>Name <input type="text" name="name" <?php echo $errors ? "value='$name'" : ""; ?>></label>
    <?php echo isset($errors["name"]) ? "<span>".$errors["name"]."</span>" : ""; ?><br>

    <label>Email <input type="email" name="email" <?php echo $errors ? "value='$email'" : ""; ?>></label>
    <?php echo isset($errors["email"]) ? "<span>".$errors["email"]."</span>" : ""; ?><br>

    <label>Message
        <textarea name="message"><?php echo $errors ? "$message" : ""; ?></textarea>
    </label>
    <?php echo isset($errors["message"]) ? "<span>".$errors["message"]."</span>" : ""; ?><br>

    <button type="submit">Send</button>
  </form>
</body>
</html>
