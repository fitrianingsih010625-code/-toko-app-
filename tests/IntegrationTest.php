<?php

require_once __DIR__ . '/../src/Barang.php';
require_once __DIR__ . '/../src/Transaksi.php';

echo "========================================\n";
echo "Integration Test: Alur Transaksi Toko\n";
echo "========================================\n\n";

$passed = true;

try {
    // 1. Test Input Barang -> Transaksi -> Total -> Struk
    echo "Skenario 1: Pembelian Normal\n";
    echo "-----------------------------\n";
    
    // Input barang
    $barang1 = new Barang("Buku Tulis", 5000);
    $barang2 = new Barang("Pensil 2B", 3000);
    $barang3 = new Barang("Penghapus", 2000);
    echo "✓ Barang berhasil dibuat\n";
    
    // Create transaksi dan input pembelian
    $transaksi = new Transaksi();
    $transaksi->tambahBarang($barang1, 2);
    $transaksi->tambahBarang($barang2, 1);
    $transaksi->tambahBarang($barang3, 3);
    echo "✓ Barang berhasil ditambahkan ke transaksi\n";
    
    // Hitung total
    $total = $transaksi->hitungTotal();
    $expectedTotal = (5000 * 2) + (3000 * 1) + (2000 * 3); // 19000
    if ($total == $expectedTotal) {
        echo "✓ Total belanja benar: Rp$total\n";
    } else {
        echo "✗ Total belanja salah!\n";
        $passed = false;
    }
    
    // Tampilkan struk
    $struk = $transaksi->tampilkanStruk();
    echo "\nOutput Struk:\n";
    echo $struk;
    
    // Verifikasi struk
    if (strpos($struk, 'Buku Tulis') !== false && 
        strpos($struk, 'Pensil 2B') !== false && 
        strpos($struk, 'Penghapus') !== false &&
        strpos($struk, '19000') !== false) {
        echo "✓ Struk berisi informasi yang benar\n";
    } else {
        echo "✗ Struk tidak lengkap!\n";
        $passed = false;
    }
    
    // 2. Test Validasi Input Invalid
    echo "\nSkenario 2: Validasi Input Invalid\n";
    echo "---------------------------------\n";
    
    try {
        $barangInvalid = new Barang("Test", -5000);
        echo "✗ Seharusnya gagal untuk harga negatif\n";
        $passed = false;
    } catch (InvalidArgumentException $e) {
        echo "✓ Validasi harga negatif: OK\n";
    }
    
    // Test jumlah 0
    try {
        $transaksi2 = new Transaksi();
        $transaksi2->tambahBarang($barang1, 0);
        echo "✗ Seharusnya gagal untuk jumlah 0\n";
        $passed = false;
    } catch (InvalidArgumentException $e) {
        echo "✓ Validasi jumlah minimal: OK\n";
    }
    
    // 3. Test Transaksi Kosong
    echo "\nSkenario 3: Transaksi Kosong\n";
    echo "----------------------------\n";
    $transaksiKosong = new Transaksi();
    $totalKosong = $transaksiKosong->hitungTotal();
    if ($totalKosong == 0.0) {
        echo "✓ Transaksi kosong menghasilkan total 0\n";
    } else {
        echo "✗ Transaksi kosong seharusnya menghasilkan total 0\n";
        $passed = false;
    }
    
} catch (Exception $e) {
    echo "\n✗ Error tidak terduga: " . $e->getMessage() . "\n";
    $passed = false;
}

// Output final result
echo "\n========================================\n";
echo "Integration Test Toko: " . ($passed ? "PASS" : "FAIL") . "\n";
echo "========================================\n";

exit($passed ? 0 : 1);