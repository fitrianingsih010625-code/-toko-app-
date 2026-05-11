<?php

class Transaksi {
    private array $items = []; // Array of ['barang' => Barang, 'jumlah' => int]
    
    /**
     * Menambahkan barang ke dalam transaksi
     */
    public function tambahBarang(Barang $barang, int $jumlah): void {
        // Validasi jumlah tidak boleh negatif
        if ($jumlah <= 0) {
            throw new InvalidArgumentException("Jumlah barang harus lebih dari 0");
        }
        
        $this->items[] = [
            'barang' => $barang,
            'jumlah' => $jumlah
        ];
    }
    
    /**
     * Menghitung total belanja
     */
    public function hitungTotal(): float {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item['barang']->getHarga() * $item['jumlah'];
        }
        return $total;
    }
    
    /**
     * Mendapatkan detail item transaksi
     */
    public function getItems(): array {
        return $this->items;
    }
    
    /**
     * Menampilkan struk
     */
    public function tampilkanStruk(): string {
        $struk = "========== STRUK PEMBELIAN ==========\n";
        $struk .= "No | Nama Barang | Harga | Jumlah | Subtotal\n";
        $struk .= "--------------------------------------------\n";
        
        $no = 1;
        foreach ($this->items as $item) {
            $barang = $item['barang'];
            $jumlah = $item['jumlah'];
            $subtotal = $barang->getHarga() * $jumlah;
            
            $struk .= sprintf(
                "%2d | %-11s | %6.0f | %6d | %8.0f\n",
                $no++,
                $barang->getNama(),
                $barang->getHarga(),
                $jumlah,
                $subtotal
            );
        }
        
        $total = $this->hitungTotal();
        $struk .= "--------------------------------------------\n";
        $struk .= sprintf("TOTAL BELANJA: %26.0f\n", $total);
        $struk .= "============================================\n";
        
        return $struk;
    }
}