<select class="form-control" name="jenis_tarif" onChange="fillPrice()" id="jenis_tarif">
    <option value="">-- Select Type--</option>
    <?php foreach ($data as $row) { ?>
        <option value="<?= $row->berat_tarif ?>,<?= $row->harga_tarif ?>"><?= $row->jenis_tarif ?> </option>
        <br>
    <?php }  ?>
    <br>
    <?= $this->db->last_query() ?>
</select>