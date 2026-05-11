<?php

require_once 'Barang.php';
require_once 'Transaksi.php';

// Membuat data barang
try {
    $barang1 = new Barang("Buku", 5000);
    $barang2 = new Barang("Pensil", 2500);
    $barang3 = new Barang("Penghapus", 1500);
    
    // Membuat transaksi
    $transaksi = new Transaksi();
    
    // Input pembelian
    $transaksi->tambahBarang($barang1, 2);
    $transaksi->tambahBarang($barang2, 3);
    $transaksi->tambahBarang($barang3, 1);
    
    // Output struk
    echo $transaksi->tampilkanStruk();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}