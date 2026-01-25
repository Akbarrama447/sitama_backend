<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label class="form-label">Judul Tugas Akhir</label>
            <div class="form-control" style="background: #fcfcfc">{{ $tugas_akhir->judul }}</div>
        </div>

        <div class="form-group mb-2 mb20">
            <label class="form-label">Mahasiswa</label>
            <div
                style="background: #fcfcfc; border: 1px solid #dfdfdf; border-radius: 5px; padding: 10px; margin-bottom: 20px;">
                <?php
                foreach ($tugas_akhir->anggota as $row) {
                    ?>
                {{ $row->mahasiswa->mhs_nama }} ({{ $row->mahasiswa->mhs_nim }})<br>
                    <?php
                }
                ?>
            </div>
        </div>
        <input type="hidden" name="tugas_akhir_id" value="{{$id}}">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Pembimbing</th>
                <th>Urutan</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <select name="pembimbing_1" class="form-control select2">
                        <?php
                        foreach ($dosen as $d) {
                            echo "<option value='" . $d->dosen_nip . "' " . (isset($bimbingan[0]) && $bimbingan[0]->dosen_nip == $d->dosen_nip ? " selected='selected'" : "") . ">" . $d->dosen_nama . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>1</td>
            </tr>
            <tr>
                <td>
                    <select name="pembimbing_2" class="form-control select2">
                        <?php
                        foreach ($dosen as $d) {
                            echo "<option value='" . $d->dosen_nip . "' " . (isset($bimbingan[1]) && $bimbingan[1]->dosen_nip == $d->dosen_nip ? " selected='selected'" : "") . ">" . $d->dosen_nama . "</option>";
                        }
                        ?>
                    </select>
                </td>
                <td>2</td>
            </tr>
            </tbody>
        </table>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>
