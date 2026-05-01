<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Pendapatan SIGANTARA</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.5;
        }

        /* Header */
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 3px solid #f9a825;
            margin-bottom: 25px;
        }
        .header h1 {
            font-size: 22px;
            color: #1a1a1a;
            margin-bottom: 4px;
            letter-spacing: 1px;
        }
        .header h2 {
            font-size: 14px;
            color: #555;
            font-weight: normal;
        }
        .header .period {
            font-size: 11px;
            color: #777;
            margin-top: 8px;
        }

        /* Summary Cards */
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        .summary-item {
            display: table-cell;
            width: 25%;
            text-align: center;
            padding: 12px 8px;
            border: 1px solid #e0e0e0;
            background: #fafafa;
        }
        .summary-item .value {
            font-size: 16px;
            font-weight: bold;
            color: #1a1a1a;
        }
        .summary-item .label {
            font-size: 9px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 4px;
        }

        /* Table */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table thead th {
            background: #f9a825;
            color: #1a1a1a;
            padding: 10px 8px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold;
            text-align: left;
            border: 1px solid #e0c050;
        }
        table.data-table tbody td {
            padding: 8px;
            border: 1px solid #e0e0e0;
            font-size: 10px;
        }
        table.data-table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        table.data-table tbody tr:hover {
            background: #fff8e1;
        }
        table.data-table tfoot td {
            padding: 10px 8px;
            font-weight: bold;
            font-size: 12px;
            border: 1px solid #e0e0e0;
            background: #fff8e1;
        }

        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-dp {
            background: #e3f2fd;
            color: #1565c0;
        }
        .badge-pelunasan {
            background: #e8f5e9;
            color: #2e7d32;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            font-size: 9px;
            color: #999;
            text-align: center;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 13px;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h1>SIGANTARA</h1>
        <h2>Laporan Pendapatan</h2>
        @if($dariTanggal && $sampaiTanggal)
            <div class="period">Periode: {{ \Carbon\Carbon::parse($dariTanggal)->format('d/m/Y') }} — {{ \Carbon\Carbon::parse($sampaiTanggal)->format('d/m/Y') }}</div>
        @elseif($dariTanggal)
            <div class="period">Dari: {{ \Carbon\Carbon::parse($dariTanggal)->format('d/m/Y') }}</div>
        @elseif($sampaiTanggal)
            <div class="period">Sampai: {{ \Carbon\Carbon::parse($sampaiTanggal)->format('d/m/Y') }}</div>
        @else
            <div class="period">Semua Periode</div>
        @endif
    </div>

    {{-- Summary --}}
    <div class="summary">
        <div class="summary-item">
            <div class="value">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</div>
            <div class="label">Total Pendapatan</div>
        </div>
        <div class="summary-item">
            <div class="value">{{ $summary['jumlah_transaksi'] }}</div>
            <div class="label">Jumlah Transaksi</div>
        </div>
        <div class="summary-item">
            <div class="value">Rp {{ number_format($summary['total_dp'], 0, ',', '.') }}</div>
            <div class="label">Total DP</div>
        </div>
        <div class="summary-item">
            <div class="value">Rp {{ number_format($summary['total_pelunasan'], 0, ',', '.') }}</div>
            <div class="label">Total Pelunasan</div>
        </div>
    </div>

    {{-- Data Table --}}
    @if($payments->count() > 0)
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 14%;">Tanggal</th>
                    <th style="width: 14%;">Kode Booking</th>
                    <th style="width: 18%;">Pelanggan</th>
                    <th style="width: 16%;">Paket</th>
                    <th style="width: 10%;">Jenis</th>
                    <th style="width: 10%;">Metode</th>
                    <th style="width: 13%;" class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $index => $payment)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $payment->verified_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td>{{ $payment->booking->kode_booking ?? '-' }}</td>
                        <td>{{ $payment->booking->user->name ?? '-' }}</td>
                        <td>{{ $payment->booking->paket->nama ?? '-' }}</td>
                        <td class="text-center">
                            <span class="badge {{ $payment->jenis === 'dp' ? 'badge-dp' : 'badge-pelunasan' }}">
                                {{ ucfirst($payment->jenis) }}
                            </span>
                        </td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payment->metode)) }}</td>
                        <td class="text-right">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="text-right">Total Pendapatan:</td>
                    <td class="text-right">Rp {{ number_format($summary['total_pendapatan'], 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    @else
        <div class="no-data">
            Tidak ada data pembayaran untuk periode ini.
        </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        Dicetak pada {{ now()->translatedFormat('d F Y, H:i') }} WIB — SIGANTARA System
    </div>
</body>
</html>
