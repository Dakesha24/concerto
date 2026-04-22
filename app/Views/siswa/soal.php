<?= $this->extend('templates/siswa/siswa_template') ?>

<meta name="robots" content="noindex,nofollow">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
<meta http-equiv="pragma" content="no-cache">

<?= $this->section('content') ?>
<div class="container py-4">
  <div class="row">
    <div class="col-12">
      <!-- Info Ujian & Timer -->
      <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h4 class="mb-0"><?= esc($ujian['nama_ujian']) ?></h4>
              <small class="text-muted"><?= esc($ujian['nama_jenis']) ?></small>
              <div class="mt-1">
                <span class="badge bg-secondary"><?= esc($ujian['kode_ujian']) ?></span>
              </div>
            </div>
            <?php if ($ujian['use_waktu']): ?>
            <div class="text-center">
              <h5 class="mb-0">Sisa Waktu</h5>
              <div id="timer" class="h4 mb-0 text-danger">
                <?= floor($sisa_waktu / 3600) ?>:<?= floor(($sisa_waktu % 3600) / 60) ?>:<?= $sisa_waktu % 60 ?>
              </div>
            </div>
            <?php endif; ?>
            <div class="text-end">
              <h5 class="mb-0">Soal</h5>
              <div class="h4 mb-0"><?= $soal_dijawab + 1 ?></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Soal -->
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title mb-0">Pertanyaan:</h5>
            <span class="badge bg-info"><?= esc($soal['kode_soal']) ?></span>
          </div>

          <div class="lead mb-4"><?= $soal['pertanyaan'] ?></div>

          <?php if (!empty($soal['foto'])): ?>
            <div class="text-center mb-4">
              <img src="<?= base_url('uploads/soal/' . $soal['foto']) ?>" alt="Gambar Soal" class="img-fluid" style="max-height: 300px;">
            </div>
          <?php endif; ?>

          <form id="formJawaban">
            <input type="hidden" name="soal_id" value="<?= $soal['soal_id'] ?>">

            <div class="list-group" id="pilihanJawaban">
              <?php
              $pilihan = [
                'A' => $soal['pilihan_a'],
                'B' => $soal['pilihan_b'],
                'C' => $soal['pilihan_c'],
                'D' => $soal['pilihan_d'],
                'E' => $soal['pilihan_e']
              ];
              foreach ($pilihan as $key => $value):
                if ($key === 'E') {
                  $cleanValue = preg_replace('/<p(\s[^>]*)?>(\s|&nbsp;|<br\s*\/?>)*<\/p>/i', '', $value);
                  $cleanValue = trim($cleanValue);
                  if (empty($cleanValue)) continue;
                } else {
                  if (empty($value)) continue;
                }
              ?>
                <label class="list-group-item list-group-item-action d-flex pilihan-item" data-pilihan="<?= $key ?>">
                  <input class="form-check-input me-2 flex-shrink-0"
                    type="radio"
                    name="jawaban"
                    value="<?= $key ?>"
                    required>
                  <span class="choice-label flex-shrink-0 me-2"><?= $key ?>.</span>
                  <div class="choice-content flex-grow-1"><?= $value ?></div>
                </label>
              <?php endforeach; ?>
            </div>

            <div class="text-end mt-4" id="wrapBtnJawab">
              <button type="submit" id="btnJawab" class="btn btn-primary btn-lg px-5">
                Jawab
              </button>
            </div>
          </form>

          <!-- Panel Feedback (tersembunyi sampai jawab) -->
          <div id="feedbackPanel" style="display:none;" class="mt-4">
            <div id="feedbackAlert" class="feedback-alert mb-3"></div>
            <div id="pembahasanBox" style="display:none;" class="pembahasan-box mb-3">
              <div class="pembahasan-label">Pembahasan</div>
              <div id="pembahasanContent"></div>
            </div>
            <div class="text-end">
              <a id="btnLanjut" href="#" class="btn btn-primary btn-lg px-5">
                Soal Berikutnya <i class="bi bi-arrow-right ms-1"></i>
              </a>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const useWaktu = <?= $ujian['use_waktu'] ? 'true' : 'false' ?>;
  const selesaiUrl = '<?= base_url('siswa/ujian/selesai/' . $ujian['jadwal_id']) ?>';

  <?php if ($ujian['use_waktu']): ?>
  let timeLeft = <?= $sisa_waktu ?>;
  const timerElement = document.getElementById('timer');

  const countDown = setInterval(() => {
    timeLeft--;
    const hours   = Math.floor(timeLeft / 3600);
    const minutes = Math.floor((timeLeft % 3600) / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = `${String(hours).padStart(2,'0')}:${String(minutes).padStart(2,'0')}:${String(seconds).padStart(2,'0')}`;
    if (timeLeft <= 0) {
      clearInterval(countDown);
      window.onbeforeunload = null;
      window.location.href = selesaiUrl;
    }
  }, 1000);
  <?php endif; ?>

  window.onbeforeunload = function() {
    return "Apakah Anda yakin ingin meninggalkan halaman ini?";
  };

  document.getElementById('formJawaban').addEventListener('submit', function(e) {
    e.preventDefault();

    const form     = this;
    const btnJawab = document.getElementById('btnJawab');
    const jawaban  = form.querySelector('input[name="jawaban"]:checked');

    if (!jawaban) return;

    // Nonaktifkan input & tombol
    form.querySelectorAll('input[type="radio"]').forEach(r => r.disabled = true);
    btnJawab.disabled     = true;
    btnJawab.textContent  = 'Memproses...';

    const formData = new FormData(form);

    fetch('<?= base_url('siswa/ujian/simpan-jawaban') ?>', {
      method: 'POST',
      body: formData,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
      if (!data.success) {
        alert('Terjadi kesalahan. Silakan coba lagi.');
        return;
      }

      // Highlight jawaban yang dipilih
      const selectedLabel = jawaban.closest('.pilihan-item');
      if (data.is_correct) {
        selectedLabel.classList.add('pilihan-benar');
      } else {
        selectedLabel.classList.add('pilihan-salah');
        // Highlight jawaban benar
        document.querySelectorAll('.pilihan-item').forEach(label => {
          if (label.dataset.pilihan === data.jawaban_benar) {
            label.classList.add('pilihan-benar');
          }
        });
      }

      if (!data.tampilkan_pembahasan) {
        // Langsung pindah tanpa feedback
        window.onbeforeunload = null;
        window.location.href = data.should_stop ? data.selesai_url : data.next_url;
        return;
      }

      // Tampilkan feedback panel
      document.getElementById('wrapBtnJawab').style.display = 'none';
      const feedbackPanel = document.getElementById('feedbackPanel');
      const feedbackAlert = document.getElementById('feedbackAlert');

      if (data.is_correct) {
        feedbackAlert.className = 'feedback-alert feedback-alert--benar';
        feedbackAlert.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i><strong>Benar!</strong> Jawaban kamu tepat.';
      } else {
        feedbackAlert.className = 'feedback-alert feedback-alert--salah';
        feedbackAlert.innerHTML = `<i class="bi bi-x-circle-fill me-2"></i><strong>Salah.</strong> Jawaban benar: <strong>${data.jawaban_benar}</strong>`;
      }

      if (data.pembahasan && data.pembahasan.trim() !== '') {
        document.getElementById('pembahasanBox').style.display  = 'block';
        document.getElementById('pembahasanContent').innerHTML  = data.pembahasan;
      }

      const btnLanjut = document.getElementById('btnLanjut');
      if (data.should_stop) {
        btnLanjut.href        = data.selesai_url;
        btnLanjut.innerHTML   = 'Selesai <i class="bi bi-flag-fill ms-1"></i>';
        btnLanjut.classList.replace('btn-primary', 'btn-success');
      } else {
        btnLanjut.href = data.next_url;
      }

      btnLanjut.addEventListener('click', function() {
        window.onbeforeunload = null;
      });

      feedbackPanel.style.display = 'block';
      feedbackPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    })
    .catch(() => {
      btnJawab.disabled    = false;
      btnJawab.textContent = 'Jawab';
      form.querySelectorAll('input[type="radio"]').forEach(r => r.disabled = false);
      alert('Gagal mengirim jawaban. Periksa koneksi internet Anda.');
    });
  });
</script>

<style>
  .lead { line-height: 1.6; }
  .lead p { margin-bottom: 1rem; }
  .lead strong, .lead b { font-weight: 600; }
  .lead em, .lead i { font-style: italic; }
  .lead sub { font-size: .8em; vertical-align: sub; }
  .lead sup { font-size: .8em; vertical-align: super; }
  .lead table { border-collapse: collapse; width: 100%; margin: 1rem 0; }
  .lead table, .lead th, .lead td { border: 1px solid #ddd; padding: 8px; }
  .lead th { background-color: #f2f2f2; }
  .lead ul, .lead ol { margin: 1rem 0; padding-left: 2rem; }

  .list-group-item { line-height: 1.5; transition: background .15s; }
  .list-group-item strong, .list-group-item b { font-weight: 600; }
  .list-group-item em, .list-group-item i { font-style: italic; }
  .list-group-item sub { font-size: .9em; vertical-align: sub; }
  .list-group-item sup { font-size: .9em; vertical-align: super; }
  .choice-label { font-weight: 600; min-width: 20px; align-self: flex-start; }
  .choice-content { line-height: 1.5; }
  .choice-content p:first-child { margin-top: 0; }
  .choice-content p:last-child { margin-bottom: 0; }

  .pilihan-benar { background: #d1fae5 !important; border-color: #6ee7b7 !important; color: #065f46 !important; }
  .pilihan-salah { background: #fee2e2 !important; border-color: #fca5a5 !important; color: #7f1d1d !important; }

  .feedback-alert { display: flex; align-items: center; padding: .875rem 1.25rem; border-radius: 10px; font-size: .95rem; }
  .feedback-alert--benar { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; }
  .feedback-alert--salah { background: #fee2e2; border: 1px solid #fca5a5; color: #7f1d1d; }

  .pembahasan-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 1rem 1.25rem; }
  .pembahasan-label { font-size: .78rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #64748b; margin-bottom: .5rem; }
</style>

<?= $this->endSection() ?>
