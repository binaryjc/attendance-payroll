<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">New Cash Advance</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/payrolls') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('Main/cash_advance_add') ?>" method="POST">
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
                    <label for="amount" class="control-label">Amount</label>
                    <input type="number" class="form-control rounded-0" id="amount" name="amount"value="<?= !empty($request->getPost('amount')) ? $request->getPost('amount') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="remarks" class="control-label">Remarks</label>
                    <input type="text" class="form-control rounded-0" id="remarks" name="remarks"value="<?= !empty($request->getPost('remarks')) ? $request->getPost('remarks') : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="status" class="control-label">Status</label>
                                <select id="status" name="status" class="form-select rounded-0">
                                    <option value="new" selected>New</option>
                                </select>
                </div>
                <div class="d-grid gap-1">
                    <button class="btn rounded-0 btn-primary bg-gradient">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>