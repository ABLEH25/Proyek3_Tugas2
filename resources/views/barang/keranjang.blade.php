
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
</head>
<body>
    <h1>Keranjang Belanja</h1>

    <p>
        <a href="{{ route('barang.index') }}">
            Kembali ke daftar barang
        </a>
    </p>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    @if ($items->isEmpty())
        <p>Keranjang masih kosong.</p>
    @else
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>
                            Rp {{ number_format((float) $item->harga, 0, ',', '.') }}
                        </td>
                        <td>
                            <form action="{{ route('keranjang.ubah', $item->id) }}"
                                  method="POST" style="display:inline">
                                @csrf
                                <input type="hidden" name="aksi" value="kurang">
                                <button type="submit">−</button>
                            </form>

                            {{ $item->jumlah }}

                            <form action="{{ route('keranjang.ubah', $item->id) }}"
                                  method="POST" style="display:inline">
                                @csrf
                                <input type="hidden" name="aksi" value="tambah">
                                <button type="submit">+</button>
                            </form>
                        </td>
                        <td>
                            Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                        </td>
                        <td>
                            <form action="{{ route('keranjang.hapus', $item->id) }}"
                                  method="POST">
                                @csrf
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>
            Total Belanja:
            Rp {{ number_format((float) $total, 0, ',', '.') }}
        </h3>

        <form action="{{ route('keranjang.kosongkan') }}" method="POST">
            @csrf
            <button type="submit">Kosongkan Keranjang</button>
        </form>
    @endif
</body>
</html>