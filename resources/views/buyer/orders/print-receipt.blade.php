<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $order->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.3;
            color: #000;
            background: #fff;
            padding: 10px;
        }

        .receipt {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #000;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .header p {
            font-size: 9px;
            color: #333;
        }

        .section {
            margin-bottom: 10px;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 5px;
            padding-bottom: 3px;
            border-bottom: 1px solid #ddd;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }

        .info-label {
            font-weight: bold;
            color: #333;
            font-size: 9px;
        }

        .info-value {
            color: #000;
            font-size: 9px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table th {
            background: #f5f5f5;
            padding: 4px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
            font-size: 9px;
        }

        table td {
            padding: 4px;
            border: 1px solid #ddd;
            font-size: 9px;
        }

        table td.text-right {
            text-align: right;
        }

        table td.text-center {
            text-align: center;
        }

        .summary {
            margin-top: 8px;
            float: right;
            width: 280px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
            padding: 2px 0;
            font-size: 9px;
        }

        .summary-row.total {
            border-top: 2px solid #000;
            padding-top: 5px;
            margin-top: 5px;
            font-size: 11px;
            font-weight: bold;
        }

        .footer {
            clear: both;
            margin-top: 15px;
            padding-top: 8px;
            border-top: 1px dashed #999;
            text-align: center;
            font-size: 8px;
            color: #666;
        }

        .bank-info {
            background: #f9f9f9;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
            margin-top: 5px;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 8px;
            font-size: 8px;
            font-weight: bold;
        }

        .status-pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .status-waiting_verification {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-processed {
            background: #E5E7EB;
            color: #374151;
        }

        .status-shipped {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .status-completed {
            background: #D1FAE5;
            color: #065F46;
        }

        .status-cancelled {
            background: #FEE2E2;
            color: #991B1B;
        }

        .two-column {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        @media print {
            body {
                padding: 0;
            }

            .no-print {
                display: none !important;
            }

            .receipt {
                max-width: 100%;
            }
        }

        .print-button {
            background: #4F46E5;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 20px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .print-button:hover {
            background: #4338CA;
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center;">
        <button class="print-button" onclick="window.print()">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak Struk
        </button>
    </div>

    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <h1>STRUK PEMBAYARAN</h1>
            <p>Marketplace - Platform Jual Beli Online</p>
        </div>

        <!-- Order Information -->
        <div class="section">
            <div class="section-title">INFORMASI PESANAN</div>
            <div class="info-row">
                <span class="info-label">No. Invoice:</span>
                <span class="info-value">{{ $order->invoice_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Pesanan:</span>
                <span class="info-value">{{ $order->created_at->format('d F Y, H:i') }} WIB</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span>
                    @php
                        $statusLabels = [
                            'pending' => 'Menunggu Pembayaran',
                            'waiting_verification' => 'Verifikasi Pembayaran',
                            'processed' => 'Diproses',
                            'shipped' => 'Dikirim',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];
                        $statusClass = 'status-' . $order->status;
                        $statusLabel = $statusLabels[$order->status] ?? ucfirst(str_replace('_', ' ', $order->status));
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                </span>
            </div>
        </div>

        <!-- Customer & Shop Information in Two Columns -->
        <div class="two-column">
            <!-- Customer Information -->
            <div class="section">
                <div class="section-title">INFORMASI PEMBELI</div>
                <div class="info-row">
                    <span class="info-label">Nama:</span>
                    <span class="info-value">{{ $order->user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email:</span>
                    <span class="info-value">{{ $order->user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat:</span>
                    <span class="info-value">{{ $order->shipping_address }}</span>
                </div>
            </div>

            <!-- Shop Information -->
            <div class="section">
                <div class="section-title">INFORMASI LAPAK</div>
                <div class="info-row">
                    <span class="info-label">Nama Lapak:</span>
                    <span class="info-value">{{ $order->shop->name }}</span>
                </div>
                @if($order->shop->address)
                    <div class="info-row">
                        <span class="info-label">Alamat:</span>
                        <span class="info-value">{{ $order->shop->address }}</span>
                    </div>
                @endif
            </div>
        </div>

        @if($order->shop->bank_name && $order->shop->bank_account_number)
            <div class="section">
                <div class="section-title">REKENING PEMBAYARAN</div>
                <div class="bank-info">
                    <div class="info-row" style="margin-bottom: 2px;">
                        <span class="info-label">Bank:</span>
                        <span class="info-value">{{ $order->shop->bank_name }}</span>
                    </div>
                    <div class="info-row" style="margin-bottom: 2px;">
                        <span class="info-label">No. Rekening:</span>
                        <span class="info-value">{{ $order->shop->bank_account_number }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Atas Nama:</span>
                        <span class="info-value">{{ $order->shop->bank_account_holder ?? $order->shop->name }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Products -->
        <div class="section">
            <div class="section-title">DAFTAR PRODUK</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama Produk</th>
                        <th style="width: 80px; text-align: center;">Qty</th>
                        <th style="width: 120px; text-align: right;">Harga Satuan</th>
                        <th style="width: 120px; text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-right">Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Shipping & Payment Summary -->
        <div class="two-column">
            <!-- Shipping Information -->
            <div class="section">
                <div class="section-title">PENGIRIMAN</div>
                <div class="info-row">
                    <span class="info-label">Kurir:</span>
                    <span class="info-value">{{ $order->shipping_courier }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Biaya:</span>
                    <span class="info-value">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="section">
                <div class="section-title">RINGKASAN</div>
                <div class="summary">
                    <div class="summary-row">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($order->total_amount - $order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkir:</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>TOTAL:</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="section">
            <div class="section-title">PEMBAYARAN</div>
            <div class="info-row">
                <span class="info-label">Metode:</span>
                <span class="info-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
            </div>
            @if($order->payment_proof)
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value" style="color: green; font-weight: bold;">✓ Bukti Pembayaran Sudah Diupload</span>
                </div>
            @else
                <div class="info-row">
                    <span class="info-label">Status:</span>
                    <span class="info-value" style="color: orange; font-weight: bold;">⚠ Menunggu Upload Bukti</span>
                </div>
            @endif
        </div>

        @if($order->status === 'cancelled' && $order->cancellation_note)
            <div class="section">
                <div class="section-title">PEMBATALAN</div>
                <div class="info-row">
                    <span class="info-label">Alasan:</span>
                    <span class="info-value">{{ $order->cancellation_note }}</span>
                </div>
            </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p><strong>Terima kasih atas pembelian Anda!</strong></p>
            <p>Dicetak pada {{ now()->format('d M Y, H:i') }} WIB</p>
        </div>
    </div>

    <script>
        // Auto print when page loads (optional - comment out if not needed)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html>
