<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
        }
        .header {
            background: #001f3f; /* Dark Blue */
            color: #b8962a; /* Gold */
            padding: 20px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
        }
        .logo {
            width: 150px;
        }
        .client-logo {
            max-width: 100px;
            max-height: 60px;
            object-contain: contain;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-details h1 {
            margin: 0;
            font-size: 32px;
            color: #b8962a;
        }
        .info-section {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-section td {
            vertical-align: top;
            width: 50%;
        }
        .label {
            font-weight: bold;
            color: #001f3f;
            text-transform: uppercase;
            font-size: 12px;
        }
        .value {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background: #001f3f;
            color: #b8962a;
            text-align: left;
            padding: 10px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .items-table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .totals {
            float: right;
            width: 40%;
        }
        .totals table {
            width: 100%;
        }
        .totals td {
            padding: 5px 0;
        }
        .totals .grand-total {
            border-top: 2px solid #001f3f;
            font-weight: bold;
            color: #001f3f;
            font-size: 18px;
        }
        .status-stamp {
            display: inline-block;
            padding: 5px 15px;
            border: 2px solid;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 20px;
            transform: rotate(-5deg);
        }
        .status-paid { color: green; border-color: green; }
        .status-partial { color: orange; border-color: orange; }
        .status-unpaid { color: red; border-color: red; }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <table>
                <tr>
                    <td>
                        @php
                            $logoPath = public_path('images/logo-light.png');
                            $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : '';
                            $logoSrc = 'data:image/png;base64,' . $logoData;
                        @endphp
                        <img src="{{ $logoSrc }}" class="logo" alt="Luxenet Logo">
                    </td>
                    <td class="invoice-details">
                        <h1>INVOICE</h1>
                        <div>#{{ $invoice->invoice_number }}</div>
                    </td>
                </tr>
            </table>
        </div>

        <table class="info-section">
            <tr>
                <td>
                    <div class="label">Invoiced From:</div>
                    <div class="value">
                        <strong>LUXENET LIMITED</strong><br>
                        Digital Intelligence Hub<br>
                        Contact: billing@luxenet.com
                    </div>
                </td>
                <td>
                    <div class="label">Invoiced To:</div>
                    <div class="value">
                        @if($invoice->client_logo)
                            @php
                                $clientLogoPath = public_path('storage/' . $invoice->client_logo);
                                if (file_exists($clientLogoPath)) {
                                    $clientLogoData = base64_encode(file_get_contents($clientLogoPath));
                                    $mime = mime_content_type($clientLogoPath);
                                    $clientLogoSrc = 'data:' . $mime . ';base64,' . $clientLogoData;
                                } else {
                                    $clientLogoSrc = '';
                                }
                            @endphp
                            @if($clientLogoSrc)
                                <img src="{{ $clientLogoSrc }}" class="client-logo"><br>
                            @endif
                        @endif
                        <strong>{{ $invoice->company_name }}</strong><br>
                        @if($invoice->person_name)
                            Attn: {{ $invoice->person_name }}<br>
                        @endif
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="label">Date:</div>
                    <div class="value">{{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</div>
                </td>
                <td>
                    <div class="label">Due Date:</div>
                    <div class="value">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</div>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }}</td>
                    <td>{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td style="text-align: right">{{ number_format($invoice->total_amount, 2) }} {{ $invoice->currency }}</td>
                </tr>
                <tr>
                    <td>Amount Paid</td>
                    <td style="text-align: right">{{ number_format($invoice->paid_amount, 2) }} {{ $invoice->currency }}</td>
                </tr>
                <tr class="grand-total">
                    <td>Balance Due</td>
                    <td style="text-align: right">{{ number_format($invoice->total_amount - $invoice->paid_amount, 2) }} {{ $invoice->currency }}</td>
                </tr>
            </table>

            @if($invoice->status == 'paid')
                <div class="status-stamp status-paid">Fully Paid</div>
            @elseif($invoice->status == 'partially_paid')
                <div class="status-stamp status-partial">Partially Paid</div>
            @else
                <div class="status-stamp status-unpaid">Payment Pending</div>
            @endif
        </div>

        <div style="clear: both;"></div>

        <div class="footer">
            <p>Thank you for your business with Luxenet.</p>
            <p>Payment should be made within the due date to avoid service interruption.</p>
        </div>
    </div>
</body>
</html>
