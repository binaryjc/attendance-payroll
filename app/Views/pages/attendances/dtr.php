<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
    <div class="d-flex w-100 justify-content-between">
                <div class="card-title h4 mb-0 fw-bolder">Employee DTR</div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-stripped table-bordered">
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">Date</th>
                    <th class="p-1 text-center">In AM</th>
                    <th class="p-1 text-center">Out AM</th>
                    <th class="p-1 text-center">In PM</th>
                    <th class="p-1 text-center">Out PM</th>
                    <th class="p-1 text-center">Late</th>
                    <th class="p-1 text-center">Undertime</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php foreach($attendances as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['id'] ?></th>
                            <td class="px-2 py-1 align-middle"><?= date("M d, Y h:i A", strtotime($row['created_at'])) ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['code'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['name'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['log_type'] == 1 ? 'Time In' : 'Time Out' ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('Main/attendance_delete/'.$row['id']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete this attendance?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(count($attendances) <= 0): ?>
                        <tr>
                            <td class="p-1 text-center" colspan="6">No result found</td>
                        </tr>
                    <?php endif ?>
                </tbody>
            </table>
            <div>
                <?= $pager->makeLinks($page, $perPage, $total, 'custom_view') ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>