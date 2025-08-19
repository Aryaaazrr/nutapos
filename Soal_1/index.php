<!-- backend -->
<?php 
$saldoAwal = 100000;

$mutasi = [
    ["tanggal" => "2021-10-01", "masuk" => 200000, "keluar" => 0],
    ["tanggal" => "2021-10-03", "masuk" => 300000, "keluar" => 0],
    ["tanggal" => "2021-10-05", "masuk" => 150000, "keluar" => 0],
    ["tanggal" => "2021-10-02", "masuk" => 0, "keluar" => 100000],
    ["tanggal" => "2021-10-04", "masuk" => 0, "keluar" => 150000],
    ["tanggal" => "2021-10-06", "masuk" => 0, "keluar" => 50000],
];

function helperFormatRupiah(int $angka): string {
    return 'Rp ' . number_format($angka, 0, ',', '.') . ',00';
}

function hitungSaldo(array $mutasi, int $saldoAwal): array {
    usort($mutasi, fn($a, $b) => strcmp($a['tanggal'], $b['tanggal']));

    $saldo = $saldoAwal;
    foreach ($mutasi as &$m) {
        $saldo += $m['masuk'];
        $saldo -= $m['keluar'];
        $m['saldo'] = $saldo;
    }
    return $mutasi;
}


$hasil = hitungSaldo($mutasi, $saldoAwal);

$jsonOutput = json_encode($hasil, JSON_PRETTY_PRINT);
?>

<!-- frontend -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mutasi Saldo</title>
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
    <pre><?= $jsonOutput; ?></pre>

    <h2>Tabel Mutasi Saldo</h2>
    <table>
        <tr>
            <th>Tanggal</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Saldo</th>
        </tr>
        <?php foreach ($hasil as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['tanggal']); ?></td>
            <td><?= helperFormatRupiah($row['masuk']); ?></td>
            <td><?= helperFormatRupiah($row['keluar']); ?></td>
            <td><?= helperFormatRupiah($row['saldo']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>