<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="font-family: Arial, Helvetica, sans-serif; color: #1e293b; background: #f8fafc; padding: 24px;">
    <div style="max-width: 480px; margin: 0 auto; background: #ffffff; border-radius: 12px; padding: 24px; border: 1px solid #e2e8f0;">
        <h2 style="margin-top: 0;">New bill added</h2>

        <p>Hi{{ $bill->unit->currentTenant ? ' '.$bill->unit->currentTenant->name : '' }},</p>

        <p>A new bill has been added to your account:</p>

        <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
            <tr>
                <td style="padding: 6px 0; color: #64748b;">Unit</td>
                <td style="padding: 6px 0; text-align: right;">{{ $unitLabel }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b;">Type</td>
                <td style="padding: 6px 0; text-align: right;">{{ ucfirst($bill->type) }}</td>
            </tr>
            @if ($bill->description)
            <tr>
                <td style="padding: 6px 0; color: #64748b;">Description</td>
                <td style="padding: 6px 0; text-align: right;">{{ $bill->description }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 6px 0; color: #64748b;">Amount</td>
                <td style="padding: 6px 0; text-align: right; font-weight: bold;">&#8369;{{ number_format((float) $bill->amount, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b;">Due date</td>
                <td style="padding: 6px 0; text-align: right;">{{ $bill->due_date->format('M j, Y') }}</td>
            </tr>
        </table>

        <p>You can view this bill and your payment history any time by logging into your tenant portal.</p>

        <p style="margin-top: 24px;">
            <a href="{{ url('/portal') }}" style="background: #2563eb; color: #ffffff; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-size: 14px;">Open tenant portal</a>
        </p>

        <p style="color: #94a3b8; font-size: 12px; margin-top: 32px;">This is an automated message from {{ config('app.name') }}.</p>
    </div>
</body>
</html>
