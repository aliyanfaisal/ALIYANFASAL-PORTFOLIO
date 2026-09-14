<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, sans-serif; color: #18181b; line-height: 1.6;">
    <h2 style="margin-bottom: 4px;">New contact message</h2>
    <p style="color: #71717a; margin-top: 0;">Submitted via aliyanfaisal.com</p>

    <table style="border-collapse: collapse; margin: 16px 0;">
        <tr>
            <td style="padding: 4px 12px 4px 0; color: #71717a;">Name</td>
            <td style="padding: 4px 0; font-weight: bold;">{{ $contactMessage->name }}</td>
        </tr>
        <tr>
            <td style="padding: 4px 12px 4px 0; color: #71717a;">Email</td>
            <td style="padding: 4px 0; font-weight: bold;">{{ $contactMessage->email }}</td>
        </tr>
        @if ($contactMessage->subject)
            <tr>
                <td style="padding: 4px 12px 4px 0; color: #71717a;">Subject</td>
                <td style="padding: 4px 0; font-weight: bold;">{{ $contactMessage->subject }}</td>
            </tr>
        @endif
    </table>

    <p style="white-space: pre-line; border-left: 3px solid #6366f1; padding-left: 12px;">{{ $contactMessage->message }}</p>
</body>
</html>
