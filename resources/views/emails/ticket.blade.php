<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketing Support</title>
    <style>
        /* Add your styling here */
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
        <h1>New Ticket</h1>
    </div>
    <div class="content">
        <!-- English Version -->
        <p style="margin-top: 30px;">Dear Manager,</p>
        <p>Here is the latest ticket related to the problem/request:</p>

        <h2>Ticket Details</h2>
        <p><strong>Ticket Number :</strong> {{ $ticket->ticket_number }}</p>
        <p><strong>Title :</strong> {{ $ticket->title }}</p>
        <p><strong>Description :</strong> {{ $ticket->description }}</p>
        <p><strong>Ticket For :</strong> 
            @switch($ticket->assigned_role)
                @case('ADMINESD')
                    ESD (Electrostatic Discharge)
                    @break
                @case('ADMINHR')
                    Human Resource
                    @break
                @case('ADMINGA')
                    General Affair
                    @break
                @case('ADMINUTILITY')
                    Utility & Building
                    @break
                @default
                    {{ $ticket->assigned_role }} <!-- Fallback to display the raw role if it doesn't match -->
            @endswitch
        </p>

        <p>You can view the ticket directly by clicking the link below:</p>
        <p><a href="http://portal.siix-ems.co.id/ticket/tickets/{{ $ticket->id }}">View Ticket</a></p>

        <p>Please check it for the approval process.</p>

        <p>Thank you,</p>
        <p>Regards,<br>Web Portal SIIX EMS Indonesia</p>
    </div>
</body>
</html>
