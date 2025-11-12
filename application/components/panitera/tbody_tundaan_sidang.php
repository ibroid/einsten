<?php foreach ($perkara_ditunda as $n => $pd) { ?>
  <tr>
    <td><?= $pd->nomor_perkara  ?></td>
    <td><?= $pd->para_pihak  ?></td>
    <td><?= $pd->alasan_ditunda  ?></td>
    <td><?= dihadiri_oleh($pd->dihadiri_oleh)  ?></td>
    <td><?= tanggal_indo($pd->ditunda_ke) ?></td>
    <td>
      <form
        hx-post="<?= base_url('instrumen_sidang/form_tundaan') ?>"
        hx-target="#modal-body-formtundaan"
        hx-on:after-swap="console.log('p')">

        <input
          value="<?= $pd->perkara_id ?>"
          type="hidden"
          name="perkara_id" />

        <input
          value="<?= $pd->sidang_id ?>"
          type="hidden"
          name="sidang_id_prev" />

        <input
          value="<?= $pd->ditunda_ke ?>"
          type="hidden"
          name="target_tanggal_sidang" />

        <div class="d-flex flex-row gap-1">
          <button
            data-bs-toggle="modal"
            data-bs-target="#modalId"
            class="btn btn-success">
            <i class="bi bi-clipboard"></i>
          </button>
          <?php
          $alreadyExists = $instrumen_hari_ini->where('sidang_id_prev', $pd->sidang_id)->all();

          if ($alreadyExists) { ?>
            <span
              class="badge bg-primary p-2">
              <?= count($alreadyExists) ?>
            </span>
          <?php }
          ?>
        </div>
      </form>
    </td>
  </tr>
<?php } ?>