<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            padding: 10px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Feedback Received</h1>
    </div>
    <div class="content">
        <p>Dear {{ $feedback->user->name }},</p>
        <p>Thank you for your feedback. Here are the details:</p>

        <h2>Feedback Details</h2>
        <p><strong>Comments:</strong> {{ $feedback->comments }}</p>
        <p><strong>Status:</strong> {{ $feedback->status }}</p>

        <p>We appreciate your input!</p>
        <p>Best Regards,<br>Web Portal SIIX EMS Indonesia</p>
    </div>
</body>
</html>
