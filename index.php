<?php
// ---------- EMAIL CHECK FUNCTION ----------
function checkEmailExists($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "❌ Invalid format";
    }

    list($user, $domain) = explode("@", $email);

    // MX lookup
    if (!getmxrr($domain, $mxhosts, $mxweights)) {
        return "❌ No MX records";
    }

    // Try SMTP connect
    $connect = @fsockopen($mxhosts[0], 25, $errno, $errstr, 10);
    if (!$connect) {
        return "⚠️ No connection ($errstr)";
    }

    stream_set_timeout($connect, 5);
    fgets($connect);

    fputs($connect, "HELO $domain\r\n");
    fgets($connect);

    fputs($connect, "MAIL FROM:<check@$domain>\r\n");
    fgets($connect);

    fputs($connect, "RCPT TO:<$email>\r\n");
    $response = fgets($connect);

    fputs($connect, "QUIT\r\n");
    fclose($connect);

    if (strpos($response, "250") !== false) {
        return "✅ Exists";
    } elseif (strpos($response, "550") !== false) {
        return "❌ Not Exists";
    } else {
        return "⚠️ Unknown ($response)";
    }
}

// ---------- FORM HANDLER ----------
$results = [];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $emails = explode("\n", trim($_POST["emails"] ?? ""));
    $emails = array_slice(array_filter(array_map("trim", $emails)), 0, 10); // Max 10 emails

    foreach ($emails as $email) {
        $results[$email] = checkEmailExists($email);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Email Existence Checker</title>
  <style>
      body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
      h1 { color: #333; }
      textarea { width: 100%; height: 150px; padding: 10px; font-size: 14px; }
      button { background: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
      button:hover { background: #45a049; }
      table { border-collapse: collapse; margin-top: 20px; width: 100%; }
      th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
      th { background: #333; color: white; }
  </style>
</head>
<body>

<h1>📧 Bulk Email Existence Checker</h1>
<p>Enter up to 10 emails (one per line) and check if they exist:</p>

<form method="post">
    <textarea name="emails" placeholder="example1@gmail.com&#10;example2@yahoo.com"></textarea><br><br>
    <button type="submit">Check Emails</button>
</form>

<?php if (!empty($results)): ?>
    <h2>Results</h2>
    <table>
        <tr><th>Email</th><th>Status</th></tr>
        <?php foreach ($results as $email => $status): ?>
            <tr><td><?= htmlspecialchars($email) ?></td><td><?= $status ?></td></tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

</body>
</html>
