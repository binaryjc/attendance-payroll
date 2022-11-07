<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
            <div class="col-auto">
                <div class="card-title h4 mb-0 fw-bolder">List of Payslips</div>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('Main/payslip_add') ?>" class="btn btn btn-primary bg-gradient rounded-0"><i class="fa fa-plus-square"></i> Add Payslip</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center mb-3">
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <form action="<?= base_url("Main/payslips") ?>" method="GET">
                <div class="input-group">
                    <input type="search" id="search" name="search" placeholder="Search employee's Code or name here.." value="<?= $request->getVar('search') ?>" class="form-control">
                    <button class="btn btn-outline-default border"><i class="fa fa-search"></i></button>
                </div>
                </form>
            </div>
        </div>
        <div class="container-fluid">
            <table class="table table-stripped table-bordered">
                <colgroup>
                    <col width="10%">
                    <col width="25%">
                    <col width="25%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <th class="p-1 text-center">#</th>
                    <th class="p-1 text-center">Payroll</th>
                    <th class="p-1 text-center">Employee</th>
                    <th class="p-1 text-center">Basic <sup>monthly</sup></th>
                    <th class="p-1 text-center">Net</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php foreach($payslips as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['id'] ?></th>
                            <td class="px-2 py-1 align-middle">
                                <div class="lh-1">
                                    <div class='mb-0'><?= $row['payroll_name'] ?></div>
                                    <div class='mb-0 text-muted'><?= $row['payroll_code'] ?></div>
                                </div>
                            </td>
                            <td class="px-2 py-1 align-middle">
                                <div class="lh-1">
                                    <div class='mb-0'><?= $row['employee_name'] ?></div>
                                    <div class='mb-0 text-muted'><?= $row['employee_code'] ?></div>
                                </div>
                            </td>
                            <td class="px-2 py-1 align-middle text-end"><?= number_format($row['salary'], 2) ?></td>
                            <td class="px-2 py-1 align-middle text-end"><?= number_format($row['net'],2) ?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('Main/payslip_view/'.$row['id']) ?>" class="mx-2 text-decoration-none text-dark"><i class="fa fa-eye"></i></a>
                                <a href="<?= base_url('Main/payslip_delete/'.$row['id']) ?>" class="mx-2 text-decoration-none text-danger" onclick="if(confirm('Are you sure to delete this payslip from list?') !== true) event.preventDefault()"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(count($payslips) <= 0): ?>
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