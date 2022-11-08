<?= $this->extend('layouts/Attendance') ?>

<?= $this->section('content') ?>
<div class="col-lg-3 col-md-4 col-sm-10 col-xs-12">
    <div class="card rounded-0">
        <div class="card-header">
            <div class="card-title h4 mb-0 text-center">Log Attendence</div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <form action="<?= base_url('Attendance/add') ?>" method="POST">
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
                        <label for="company_code" class="control-label">Enter Employee Code</label>
                        <input type="text" class="form-control rounded-0" id="company_code" name="company_code" autofocus placeholder="XXXXX" value="<?= !empty($request->getPost('company_code')) ? $request->getPost('company_code') : '' ?>" required="required">
                    </div>
                    <div class="mb-3 text-center">
                        <button class="btn rounded-0 btn-primary btn-lg bg-gradient" name="time_in">Time In</button>
                        <button class="btn rounded-0 btn-danger btn-lg bg-gradient" name="time_out">Time Out</button>
                    </div>
                    <div class="mb-3 text-center">
                        <img src="<?=base_url()?>/public/assets/images/adslablogo.png">
                    </div>
                    <div class="mb-3">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>