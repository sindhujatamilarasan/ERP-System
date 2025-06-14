<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice — {{ $order->order_number }}</title>
    <style>
        /*** Global ***/
        body { font-family: DejaVu Sans, sans-serif; color: #333; }
        h1, h2, h3, h4, h5 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
        th, td { padding: 0.5rem; border: 1px solid #ddd; }

        /*** Header ***/
        .invoice-header { margin-bottom: 2rem; }
        .invoice-header .logo { float: left; }
        .invoice-header .company-details { float: right; text-align: right; }
        .clearfix::after { content: ""; display: table; clear: both; }

        /*** Invoice info ***/
        .invoice-details { margin-bottom: 2rem; }
        .invoice-details .bill-to { float: left; }
        .invoice-details .invoice-meta { float: right; text-align: right; }
        .invoice-details .invoice-meta th,
        .invoice-details .invoice-meta td { border: none; padding: 0.2rem 0; }

        /*** Totals ***/
        .totals { margin-top: 1rem; float: right; width: 40%; }
        .totals th, .totals td { border: none; padding: 0.5rem; }

        /*** Footer ***/
        .invoice-footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 0.8rem; color: #777; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="invoice-header clearfix">
        <div class="logo">
            {{-- You can embed your logo as an <img src="path/to/logo.png" style="max-height:60px;"> --}}
            <h2>ERP Systems Pvt Lmt</h2>
            <p>123 Business St.<br>City, State ZIP<br>Phone: (555) 123‑4567</p>
        </div>
        <div class="company-details">
            <h3>INVOICE</h3>
            <p><strong>#{{ $order->order_number }}</strong><br>
            Date: {{ $order->created_at->format('d M, Y') }}</p>
        </div>
    </div>

    <!-- Items Table -->
    <table>
        <thead>
            <tr style="background: #f5f5f5;">
                <th style="width: 50%;">Product</th>
                <th style="width: 15%; text-align: center;">Qty</th>
                <th style="width: 17%; text-align: right;">Unit Price</th>
                <th style="width: 18%; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">₹{{ number_format($item->price, 2) }}</td>
                    <td style="text-align: right;">₹{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <table class="totals">
        <tr>
            <th style="text-align: left;">Total</th>
            <td style="text-align: right;"><strong>₹{{ number_format($order->total, 2) }}</strong></td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="invoice-footer">
        Thank you for your business! If you have any questions, contact us at support@yourcompany.com
    </div>

</body>
</html>
