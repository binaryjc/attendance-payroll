<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Check Employee DTR</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/payrolls') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('Attendance/employee_dtr') ?>" method="POST">
                <?php if($session->getFlashdata('error')): ?>
                    <div class="alert alert-danger rounded-0">
                        <?= $session->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <?php if($session->getFlashdata('success')): ?>
                    <div class="alert alert-success rounded-0">
                        <?= $session->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <div class="mb-3">
                                <label for="employee_id" class="control-label">Employee</label>
                                <select id="employee_id" name="employee_id" class="form-select rounded-0">
                                    <option value="" disabled selected></option>
                                    <?php
                                        foreach($employees as $row):
                                    ?>
                                        <option value="<?= $row['id'] ?>" data-salary="<?= $row['salary'] ?>"><?= $row['code']. " - " .$row['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                </div>
                <div class="mb-3">
                    <label for="from_date" class="control-label">Date From</label>
                    <input type="date" class="form-control rounded-0" id="from_date" name="from_date"value="<?= !empty($request->getPost('from_date')) ? $request->getPost('from_date') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="to_date" class="control-label">Date To</label>
                    <input type="date" class="form-control rounded-0" id="to_date" name="to_date"value="<?= !empty($request->getPost('to_date')) ? $request->getPost('to_date') : '' ?>" required="required">
                </div>
                <div class="d-grid gap-1">
                    <button class="btn rounded-0 btn-primary bg-gradient">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>