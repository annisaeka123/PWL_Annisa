<!DOCTYPE html>
<html>
<head>
    <title>Home - POS</title>
</head>
<body>
    <h1>Welcome to POS (Point of Sales)</h1>
    <h3>Menu:</h3>
    <a href="{{ url('/level') }}"><button>Level</button></a>
    <br> <br>
    <a href="{{ url('/user') }}"><button>User</button></a>
    <br> <br>
    <a href="{{ url('/kategori') }}"><button>Kategori Barang</button></a>
    <br> <br>
    <a href="{{ url('/barang') }}"><button>Barang</button></a>
    <br> <br>
    <a href="{{ url('/supplier') }}"><button>Supplier</button></a>
    <br> <br>
    <a href="{{ url('/stok') }}"><button>Stok</button></a>
    <br> <br>
    <a href="{{ url('/penjualan') }}"><button>Penjualan</button></a>
    <br> <br>
    <a href="{{ url('/penjualan_detail') }}"><button>Detail Penjualan</button></a>
</body>
</html>



