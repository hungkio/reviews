<!DOCTYPE html>
<html>
<head>
    <title>Sent Emails</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Sent Emails</h2>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Customer Email</th>
                <th>Customer Name</th>
                <th>Payment ID</th>
                <th>Review Request Subject</th>
                <th>Review Request Body</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sentEmails as $details)
                <tr>
                    <td>{{ $details['type'] ?? ''}}</td>
                    <td>{{ $details['data']->email ?? ''}}</td>
                    <td>{{ $details['data']->name ?? ''}}</td>
                    <td>{{ $details['payment']->id ?? ''}}</td>
                    <td>{{ $details['reviewRequests']->email_subject ?? ''}}</td>
                    <td>{{ $details['reviewRequests']->email_body ?? ''}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
