<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Cash Advance Details</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/cash_advance') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-angle-left"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('Main/cash_advance_update') ?>" method="POST">
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
                    <input type="text" class="form-control rounded-0" disabled value="<?= isset($cashad['name']) ? $cashad['name'] : '' ?>">
                    <input type="hidden" class="form-control rounded-0" name="ca_id" value="<?= isset($cashad['ca_id']) ? $cashad['ca_id'] : '' ?>">
                                
                </div>
                <div class="mb-3">
                    <label for="employee_id" class="control-label">Date Added</label>
                    <input type="text" class="form-control rounded-0" disabled value="<?= date("M d, Y h:i A", strtotime($cashad['created_at'])) ?>">
                </div>
                <div class="mb-3">
                    <label for="employee_id" class="control-label">Date Last Updated</label>
                    <input type="text" class="form-control rounded-0" disabled value="<?= date("M d, Y h:i A", strtotime($cashad['updated_at'])) ?>">
                </div>

                <div class="mb-3">
                    <label for="amount" class="control-label">Amount</label>
                    <input type="number" class="form-control rounded-0" id="amount" name="amount"value="<?= isset($cashad['amount']) ? $cashad['amount'] : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="remarks" class="control-label">Remarks</label>
                    <input type="text" class="form-control rounded-0" id="remarks" name="remarks"value="<?= isset($cashad['remarks']) ? $cashad['remarks'] : '' ?>" required="required">
                </div>
                <div class="mb-3">
                    <label for="status" class="control-label">Status</label>
                                <select id="status" name="status" class="form-select rounded-0">
                                    <option value="new" <?= isset($cashad['status']) && $cashad['status'] == 'new' ? 'selected' : '' ?> >New</option>
                                    <option value="partial_paid" <?= isset($cashad['status']) && $cashad['status'] == 'partial_paid' ? 'selected' : '' ?> >Partial Paid</option>
                                    <option value="fully_paid" <?= isset($cashad['status']) && $cashad['status'] == 'fully_paid' ? 'selected' : '' ?> >Fully Paid</option>
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