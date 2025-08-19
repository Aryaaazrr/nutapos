<!-- backend -->
<?php 
$saldoAwalStok = 0;

$saldoAwalStokRp = 0;

$kartuStok = [
    ['tanggal' => '2021-10-01', 'masuk' => 10, 'keluar' => 0, 'saldoQty' => 0, 'masukRp' => 10000, 'keluarRp' => 0, 'saldoRp' => 0],
    ['tanggal' => '2021-10-03', 'masuk' => 45, 'keluar' => 0, 'saldoQty' => 0, 'masukRp' => 36000, 'keluarRp' => 0, 'saldoRp' => 0],
    ['tanggal' => '2021-10-05', 'masuk' => 40, 'keluar' => 0, 'saldoQty' => 0, 'masukRp' => 35000, 'keluarRp' => 0, 'saldoRp' => 0],
    ['tanggal' => '2021-10-02', 'masuk' => 0, 'keluar' => 5, 'saldoQty' => 0, 'masukRp' => 0, 'keluarRp' => 0, 'saldoRp' => 0],
    ['tanggal' => '2021-10-04', 'masuk' => 0, 'keluar' => 40, 'saldoQty' => 0, 'masukRp' => 0, 'keluarRp' => 0, 'saldoRp' => 0],
    ['tanggal' => '2021-10-06', 'masuk' => 0, 'keluar' => 35, 'saldoQty' => 0, 'masukRp' => 0, 'keluarRp' => 0, 'saldoRp' => 0],
];

function helperFormatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.') . ',00';
}

function hitungKartuStok(array $kartuStok, int $saldoAwalStok, int $saldoAwalStokRp): array {
    usort($kartuStok, fn($a, $b) => strcmp($a['tanggal'], $b['tanggal']));
    
    $saldoQty = $saldoAwalStok;
    $saldoRp = $saldoAwalStokRp;
    foreach ($kartuStok as &$item) {
       if ($item['keluar'] > 0 && $saldoQty > 0) {
            $hargaRata2   = $saldoRp / $saldoQty;
            $item['keluarRp'] = $hargaRata2 * $item['keluar'];
        }

        $saldoQty += $item['masuk'] - $item['keluar'];
        $saldoRp  += $item['masukRp'] - $item['keluarRp'];

        $item['saldoQty'] = $saldoQty;
        $item['saldoRp']  = $saldoRp;
    }
    return $kartuStok;
}
$hasilKartuStok = hitungKartuStok($kartuStok, $saldoAwalStok, $saldoAwalStokRp);
$jsonOutputKartuStok = json_encode($hasilKartuStok, JSON_PRETTY_PRINT);
?>

<!-- frontend -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akumulasi Stok</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    pre {
        background: #f4f4f4;
        padding: 10px;
        border-radius: 5px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    th {
        background-color: #007bff;
        color: white;
    }
    </style>
</head>

<body>
    <h2>Output JSON</h2>
    <pre><?php echo htmlspecialchars($jsonOutputKartuStok); ?></pre>

    <h2>Tabel Akumulasi</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Masuk (Qty)</th>
                <th>Keluar (Qty)</th>
                <th>Saldo (Qty)</th>
                <th>Masuk (Rp)</th>
                <th>Keluar (Rp)</th>
                <th>Saldo (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hasilKartuStok as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['tanggal']); ?></td>
                <td><?= htmlspecialchars($row['masuk']); ?></td>
                <td><?= htmlspecialchars($row['keluar']); ?></td>
                <td><?= htmlspecialchars($row['saldoQty']); ?></td>
                <td><?= helperFormatRupiah($row['masukRp']); ?></td>
                <td><?= helperFormatRupiah($row['keluarRp']); ?></td>
                <td><?= helperFormatRupiah($row['saldoRp']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>