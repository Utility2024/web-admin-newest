<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Ticket Created</title>
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
        <h1>Ticket Created</h1>
    </div>
    <div class="content">
        <p>Dear User,</p>
        <p>Your ticket has been successfully created. Here are the details:</p>

        <h2>Ticket Details</h2>
        <p><strong>Ticket Number :</strong> {{ $ticket->ticket_number }}</p>
        <p><strong>Title :</strong> {{ $ticket->title }}</p>
        <p><strong>Description :</strong> {{ $ticket->description }}</p>

        <p>You can view your ticket directly by clicking the link below:</p>
        <p><a href="/ticket/tickets/{{ $ticket->id }}">View Ticket</a></p>

        <p>Thank you for reaching out!</p>
        <p>Best Regards,<br>Web Portal SIIX EMS Indonesia</p>
    </div>
</body>
</html>
