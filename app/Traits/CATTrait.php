<?php

namespace App\Traits;

trait CATTrait
{
    /**
     * Hitung T-score keterampilan berpikir kritis.
     * T_score = 50 + 10 * ((θ_fi + θ̄_f) / SD)
     *
     * Jika hanya 1 siswa atau SD = 0, kembalikan 50 (posisi rata-rata).
     */
    protected function hitungKemampuanKognitif(float $theta_fi, $ujianId = null): float
    {
        if ($ujianId === null) {
            return round(max(0, 50 + (16.67 * $theta_fi)), 2);
        }

        ['theta_bar' => $theta_bar, 'sd' => $sd] = $this->getStatistikTheta((int)$ujianId);

        if ($sd == 0) {
            return 50.0;
        }

        return round(50 + 10 * (($theta_fi + $theta_bar) / $sd), 2);
    }

    /**
     * Hitung rata-rata dan SD theta akhir seluruh siswa yang selesai
     * mengerjakan ujian dengan ujian_id tertentu.
     * Hasil di-cache per request agar tidak query DB berulang.
     */
    protected function getStatistikTheta(int $ujianId): array
    {
        static $cache = [];

        if (isset($cache[$ujianId])) {
            return $cache[$ujianId];
        }

        $db   = \Config\Database::connect();
        $rows = $db->query(
            "SELECT hu.theta_saat_ini
             FROM hasil_ujian hu
             INNER JOIN peserta_ujian pu ON pu.peserta_ujian_id = hu.peserta_ujian_id
             INNER JOIN jadwal_ujian ju  ON ju.jadwal_id = pu.jadwal_id
             WHERE ju.ujian_id = ?
               AND pu.status   = 'selesai'
               AND hu.waktu_menjawab = (
                   SELECT MAX(hu2.waktu_menjawab)
                   FROM hasil_ujian hu2
                   WHERE hu2.peserta_ujian_id = hu.peserta_ujian_id
               )",
            [$ujianId]
        )->getResultArray();

        $thetas = array_map('floatval', array_column($rows, 'theta_saat_ini'));
        $n      = count($thetas);

        if ($n < 2) {
            $cache[$ujianId] = ['theta_bar' => $n === 1 ? $thetas[0] : 0.0, 'sd' => 0.0];
            return $cache[$ujianId];
        }

        $theta_bar = array_sum($thetas) / $n;
        $variance  = array_sum(array_map(fn($t) => ($t - $theta_bar) ** 2, $thetas)) / $n;
        $sd        = sqrt($variance);

        $cache[$ujianId] = ['theta_bar' => $theta_bar, 'sd' => $sd];
        return $cache[$ujianId];
    }

    /**
     * Kategori T-score keterampilan berpikir kritis (5 kategori).
     */
    protected function getKlasifikasiKognitif(float $skor): array
    {
        if ($skor < 35) {
            return ['kategori' => 'Sangat Rendah', 'class' => 'text-danger',  'bg_class' => 'bg-danger'];
        } elseif ($skor < 45) {
            return ['kategori' => 'Rendah',        'class' => 'text-orange',  'bg_class' => 'bg-orange'];
        } elseif ($skor < 55) {
            return ['kategori' => 'Sedang',         'class' => 'text-warning', 'bg_class' => 'bg-warning'];
        } elseif ($skor < 65) {
            return ['kategori' => 'Tinggi',         'class' => 'text-info',    'bg_class' => 'bg-info'];
        } else {
            return ['kategori' => 'Sangat Tinggi',  'class' => 'text-success', 'bg_class' => 'bg-success'];
        }
    }

    /**
     * Menghitung durasi pengerjaan per soal
     */
    protected function hitungDurasiPerSoal($detailJawaban, $waktuMulaiUjian)
    {
        $hasilDenganDurasi = [];
        $waktuSebelumnya   = $waktuMulaiUjian;

        foreach ($detailJawaban as $index => $jawaban) {
            $waktuMenjawab = $jawaban['waktu_menjawab'];
            $durasiDetik   = strtotime($waktuMenjawab) - strtotime($waktuSebelumnya);

            $jawaban['durasi_pengerjaan_detik']  = $durasiDetik;
            $jawaban['durasi_pengerjaan_format'] = sprintf('%d menit %d detik', floor($durasiDetik / 60), $durasiDetik % 60);
            $jawaban['nomor_soal']               = $index + 1;

            $hasilDenganDurasi[] = $jawaban;
            $waktuSebelumnya     = $waktuMenjawab;
        }

        return $hasilDenganDurasi;
    }
}
