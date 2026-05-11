<?php

class Barang {
    private string $nama;
    private float $harga;
    
    public function __construct(string $nama, float $harga) {
        // Validasi tidak boleh negatif
        if ($harga < 0) {
            throw new InvalidArgumentException("Harga tidak boleh negatif");
        }
        if (empty(trim($nama))) {
            throw new InvalidArgumentException("Nama barang tidak boleh kosong");
        }
        
        $this->nama = $nama;
        $this->harga = $harga;
    }
    
    public function getNama(): string {
        return $this->nama;
    }
    
    public function getHarga(): float {
        return $this->harga;
    }
}