<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
    <div class="d-flex w-100 justify-content-between">
                <div class="card-title h4 mb-0 fw-bolder">Attendances</div>
            <div class="col-auto">
                <a href="<?= base_url('Attendance/employee_dtr_table') ?>" class="btn btn btn-primary bg-gradient border rounded-0"><i class="fa fa-clock"></i> Check Employee DTR</a>
                <a href="<?= base_url('Attendance/attendance_list_add') ?>" class="btn btn btn-primary bg-gradient border rounded-0"><i class="fa fa-table"></i> Add DTR Entry</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center mb-3">
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <form action="<?= base_url("Attendance/attendance_list") ?>" method="GET">
                <div class="input-group">
                    <input type="search" id="search" name="search" placeholder="Search employee's Code or name here.." value="<?= $request->getVar('search') ?>" class="form-control">
                    <button class="btn btn-outline-default border"><i class="fa fa-search"></i></button>
                </div>
                </form>
            </div>
        </div>
        <div class="container-fluid">
            <table class="table table-stripped table-bordered">
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">DateTime</th>
                    <th class="p-1 text-center">Company Code</th>
                    <th class="p-1 text-center">Name</th>
                    <th class="p-1 text-center">Log Type</th>
                    <th class="p-1 text-center">Time Type</th>
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
                            <td class="px-2 py-1 align-middle"><?= $row['time_type'] == 'am' ? 'AM' : 'PM' ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('Attendance/attendance_edit/'.$row['id']) ?>" class="mx-2 text-decoration-none text-primary"><i class="fa fa-edit"></i></a>
                                <a href="<?= base_url('Attendance/attendance_delete/'.$row['id']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete this attendance?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
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