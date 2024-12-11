<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Invoice {{ $transactions->no_invoice }}</title>
</head>
<body>
  <table style="width: 100%">
    <thead>
      <tr>
        <th style="text-align: left;">Toko</th>
        <th style="text-align: right;">Transaksi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="text-align: left;">{{ $store->name }}</td>
        <td style="text-align: right;">{{ $transactions->no_invoice }}</td>
      </tr>
      <tr>
        <td style="text-align: left;">Kasir: {{ $transactions->createdBy->name }}</td>
        <td style="text-align: right;">{{ $transactions->created_at->format('d/m/Y') }}</td>
      </tr>
      <tr>
        <td style="text-align: left;">{{ $store->address ?? "-" }}</td>
        <td style="text-align: right;">Rp. {{ number_format($transactions->total, 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>
  <hr>
  <table style="width: 100%">
    <thead style="background-color: rgb(36, 34, 160); color: #fff;">
      <tr>
        <th style="width: 5%">#</th>
        <th style="width: 25%">Barang</th>
        <th style="width: 5%">Jumlah</th>
        <th style="width: 17%">Harga</th>
        <th style="width: 17%">Diskon</th>
        <th style="width: 17%">Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($transactions->carts as $cart)
        <tr>
          <td style="text-align: center">{{ $loop->iteration }}</td>
          <td style="text-align: left">{{ $cart->product->name }}</td>
          <td style="text-align: center">{{ $cart->quantity }}</td>
          <td style="text-align: right">Rp. {{ number_format($cart->price, 0, ',', '.') }}</td>
          <td style="text-align: right">Rp. {{ number_format($cart->product_discount, 0, ',', '.') }}</td>
          <td style="text-align: right">Rp. {{ number_format(($cart->price - $cart->product_discount) * $cart->quantity, 0, ',', '.') }}</td>
        </tr>
      @endforeach
      <tr>
        <td colspan="6" style="padding: 10px;"></td>
      </tr>
      <tr>
        <th colspan="5" style="text-align: right;">Total Item</th>
        <td style="text-align: right;">Rp. {{ number_format($transactions->total_item, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <th colspan="5" style="text-align: right;">Diskon</th>
        <td style="text-align: right;">Rp. {{ number_format($transactions->transaction_discount, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <th colspan="5" style="text-align: right;">PPN</th>
        <td style="text-align: right;">Rp. {{ number_format($transactions->ppn, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <th colspan="5" style="text-align: right;">Total Belanja</th>
        <td style="text-align: right;">Rp. {{ number_format($transactions->total, 0, ',', '.') }}</td>
      </tr>
    </tbody>
  </table>
</body>
</html>