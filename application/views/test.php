<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<p>
    <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
</p>
<h4>Data dari model data method get:</h4>
<ul>
    <?php foreach ($get as $key => $value) : ?>
        <li><?= "$value->mahasiswa - $value->nama_prodi" ?></li>
    <?php endforeach; ?>
</ul>

<h4>Data dari model data method find:</h4>
<p><?= "$find->nama - $find->nim" ?></p>

<h4>Tambah data :</h4>
<p><?= "$insert" ?></p>