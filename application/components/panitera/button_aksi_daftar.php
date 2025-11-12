<div class="dropdown">
  <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    Pilihan
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" href="#">Check Relaas</a></li>
    <li><a class="dropdown-item bg-warning" href="<?= base_url('instrumen_sidang/ubah/' . $data->id) ?>">Edit</a></li>
    <li>
      <a
        onclick="hapusInstrumen(<?= $data->id ?>)"
        class="dropdown-item bg-danger"
        href="javascript:void(0)">
        Hapus
      </a>
    </li>
  </ul>
</div>