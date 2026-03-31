<?php

namespace App\Traits;

trait CATTrait
{
    /**
     * Menghitung kemampuan kognitif berdasarkan nilai theta
     * Rumus: 50 + (16.67 * theta)
     */
    protected function hitungKemampuanKognitif($theta)
    {
        $skor_akhir = 50 + (16.67 * $theta);
        return round(max(0, $skor_akhir), 2);
    }

    /**
     * Mendapatkan klasifikasi berdasarkan skor kognitif
     */
    protected function getKlasifikasiKognitif($skor)
    {
        if ($skor < 25) {
            return [
                'kategori' => 'Sangat Rendah',
                'class' => 'text-danger',
                'bg_class' => 'bg-danger'
            ];
        } elseif ($skor >= 25 && $skor < 42) {
            return [
                'kategori' => 'Rendah',
                'class' => 'text-orange',
                'bg_class' => 'bg-orange'
            ];
        } elseif ($skor >= 42 && $skor < 58) {
            return [
                'kategori' => 'Cukup',
                'class' => 'text-warning',
                'bg_class' => 'bg-warning'
            ];
        } elseif ($skor >= 58 && $skor < 75) {
            return [
                'kategori' => 'Baik',
                'class' => 'text-info',
                'bg_class' => 'bg-info'
            ];
        } else {
            return [
                'kategori' => 'Sangat Baik',
                'class' => 'text-success',
                'bg_class' => 'bg-success'
            ];
        }
    }

    /**
     * Menghitung durasi pengerjaan per soal
     */
    protected function hitungDurasiPerSoal($detailJawaban, $waktuMulaiUjian)
    {
        $hasilDenganDurasi = [];
        $waktuSebelumnya = $waktuMulaiUjian;

        foreach ($detailJawaban as $index => $jawaban) {
            $waktuMenjawab = $jawaban['waktu_menjawab'];
            $durasiDetik = strtotime($waktuMenjawab) - strtotime($waktuSebelumnya);

            $menit = floor($durasiDetik / 60);
            $detik = $durasiDetik % 60;

            $jawaban['durasi_pengerjaan_detik'] = $durasiDetik;
            $jawaban['durasi_pengerjaan_format'] = sprintf('%d menit %d detik', $menit, $detik);
            $jawaban['nomor_soal'] = $index + 1;

            $hasilDenganDurasi[] = $jawaban;
            $waktuSebelumnya = $waktuMenjawab;
        }

        return $hasilDenganDurasi;
    }
}
