<!DOCTYPE html>
<html>
<head>
    <title>Struk Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .center { text-align: center; }
    </style>
</head>
<body>
    <h2 class="center">Struk Penjualan</h2>

    <table>
        <tr>
            <th>ID</th>
            <td>{{ $penjualan->penjualan_id }}</td>
        </tr>
        <tr>
            <th>User</th>
            <td>{{ $penjualan->user->nama }}</td>
        </tr>
        <tr>
            <th>Pembeli</th>
            <td>{{ $penjualan->pembeli }}</td>
        </tr>
        <tr>
            <th>Kode Penjualan</th>
            <td>{{ $penjualan->penjualan_kode }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ \Carbon\Carbon::parse($penjualan->penjualan_tanggal)->format('d/m/Y') }}</td>
        </tr>
    </table>

    <h4>Detail Barang</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($penjualan->detail as $i => $item)
                @php $total += $item->harga; @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->barang->barang_nama }}</td>
                    <td class="text-right">{{ number_format($item->barang->harga_jual, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->jumlah }}</td>
                    <td class="text-right">{{ number_format($item->harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="4" class="text-right">Total</th>
                <th class="text-right">{{ number_format($total, 0, ',', '.') }}</th>
            </tr>
        </tbody>
    </table>

    <p><small>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</small></p>
</body>
</html>
