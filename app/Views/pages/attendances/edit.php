<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">Edit Employee DTR</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Attendance/attendance_list') ?>" class="btn btn btn-light bg-gradient border rounded-0"><i class="fa fa-table"></i> Back to List</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <form action="<?= base_url('Attendance/attendance_list_update') ?>" method="POST">
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
                    <input type="text" class="form-control rounded-0" disabled value="<?= isset($employee['name']) ? $employee['name'] : '' ?>">
                    <input type="hidden" class="form-control rounded-0" name="employee_id" value="<?= isset($employee['id']) ? $employee['id'] : '' ?>">
                    <input type="hidden" class="form-control rounded-0" name="dtr_id" value="<?= isset($dtr_data['id']) ? $dtr_data['id'] : '' ?>">

                <div class="mb-3">
                    <label class="control-label">Old Date Time</label>
                    <input type="text" class="form-control rounded-0" disabled value="<?=$dtr_data['created_at']?>">
                </div>
                <div class="mb-3">
                    <label for="from_date" class="control-label">New Date</label>
                    <input type="date" class="form-control rounded-0" id="from_date" name="from_date"  required="required">
                </div>
                <div class="mb-3">
                    <label for="appt" class="control-label">New Time</label>
                    <input type="time" id="appt" name="appt" class="form-control rounded-0" required>
                </div>
                <div class="mb-3">
                    <label for="logtype" class="control-label">Log Type</label>
                                <select id="logtype" name="log_type" class="form-select rounded-0" required>
                                    <option value="1" <?= isset($dtr_data['log_type']) && $dtr_data['log_type'] == '1' ? 'selected' : '' ?>>Time In</option>
                                    <option value="2" <?= isset($dtr_data['log_type']) && $dtr_data['log_type'] == '2' ? 'selected' : '' ?>>Time Out</option>
                                </select>
                </div>
                <div class="mb-3">
                    <label for="timetype" class="control-label">Time Type</label>
                                <select id="timetype" name="time_type" class="form-select rounded-0" required>
                                    <option value="am" <?= isset($dtr_data['time_type']) && $dtr_data['time_type'] == 'am' ? 'selected' : '' ?>>AM</option>
                                    <option value="pm" <?= isset($dtr_data['time_type']) && $dtr_data['time_type'] == 'pm' ? 'selected' : '' ?>>PM</option>
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