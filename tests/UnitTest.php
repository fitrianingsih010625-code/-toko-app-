<?php

require_once __DIR__ . '/../src/Barang.php';
require_once __DIR__ . '/../src/Transaksi.php';

class UnitTest {
    private $passed = 0;
    private $failed = 0;
    
    public function testHitungTotalBelanja() {
        echo "Test Perhitungan Total Belanja:\n";
        
        try {
            $barang1 = new Barang("Buku", 5000);
            $barang2 = new Barang("Pensil", 2500);
            
            $transaksi = new Transaksi();
            $transaksi->tambahBarang($barang1, 2);  // 2 x 5000 = 10000
            $transaksi->tambahBarang($barang2, 3);  // 3 x 2500 = 7500
            
            $total = $transaksi->hitungTotal();
            $expected = 17500;
            
            if ($total === $expected) {
                echo "  ✓ Total belanja benar: $total\n";
                $this->passed++;
            } else {
                echo "  ✗ Total salah. Expected: $expected, Got: $total\n";
                $this->failed++;
            }
        } catch (Exception $e) {
            echo "  ✗ Error: " . $e->getMessage() . "\n";
            $this->failed++;
        }
    }
    
    public function testInputBarang() {
        echo "\nTest Input Barang:\n";
        
        try {
            // Test input normal
            $barang = new Barang("Penggaris", 3000);
            echo "  ✓ Berhasil input barang: {$barang->getNama()} - Rp{$barang->getHarga()}\n";
            $this->passed++;
            
            // Test input dengan harga negatif (harus gagal)
            try {
                $barangInvalid = new Barang("Test", -1000);
                echo "  ✗ Seharusnya gagal untuk harga negatif\n";
                $this->failed++;
            } catch (InvalidArgumentException $e) {
                echo "  ✓ Validasi harga negatif berfungsi: {$e->getMessage()}\n";
                $this->passed++;
            }
            
            // Test input dengan nama kosong
            try {
                $barangInvalid = new Barang("", 1000);
                echo "  ✗ Seharusnya gagal untuk nama kosong\n";
                $this->failed++;
            } catch (InvalidArgumentException $e) {
                echo "  ✓ Validasi nama kosong berfungsi: {$e->getMessage()}\n";
                $this->passed++;
            }
            
            // Test transaksi dengan jumlah <= 0
            $transaksi = new Transaksi();
            $barangTest = new Barang("Test", 1000);
            try {
                $transaksi->tambahBarang($barangTest, 0);
                echo "  ✗ Seharusnya gagal untuk jumlah 0\n";
                $this->failed++;
            } catch (InvalidArgumentException $e) {
                echo "  ✓ Validasi jumlah 0 berfungsi: {$e->getMessage()}\n";
                $this->passed++;
            }
            
        } catch (Exception $e) {
            echo "  ✗ Error: " . $e->getMessage() . "\n";
            $this->failed++;
        }
    }
    
    public function getResults() {
        return ['passed' => $this->passed, 'failed' => $this->failed];
    }
}

// Run tests
$test = new UnitTest();
$test->testHitungTotalBelanja();
$test->testInputBarang();

$results = $test->getResults();
echo "\n========================================\n";
echo "Unit Test Total Belanja: " . ($results['failed'] > 0 ? "FAIL" : "PASS") . "\n";
echo "Unit Test Input Barang: " . ($results['failed'] > 0 ? "FAIL" : "PASS") . "\n";
echo "========================================\n";

// Exit with appropriate code
exit($results['failed'] > 0 ? 1 : 0);