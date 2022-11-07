<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header">
    <div class="d-flex w-100 justify-content-between">
                <div class="card-title h4 mb-0 fw-bolder">Cash Advances</div>
            <div class="col-auto">


                <a href="<?= base_url('Main/cash_advance_form') ?>" class="btn btn btn-primary bg-gradient rounded-0"><i class="fa fa-plus-square"></i> Add CA</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row justify-content-center mb-3">
            <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">
                <form action="<?= base_url("Main/cash_advance") ?>" method="GET">
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
                    <th class="p-1 text-center">Employee</th>
                    <th class="p-1 text-center">Amount</th>
                    <th class="p-1 text-center">Date</th>
                    <th class="p-1 text-center">Updated</th>
                    <th class="p-1 text-center">Status</th>
                    <th class="p-1 text-center">Action</th>
                </thead>
                <tbody>
                    <?php foreach($cash_advances as $row): ?>
                        <tr>
                            <th class="p-1 text-center align-middle"><?= $row['id'] ?></th>
                            <td class="px-2 py-1 align-middle"><?= $row['name'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['amount'] ?></td>
                            <td class="px-2 py-1 align-middle"><?= date("M d, Y h:i A", strtotime($row['created_at'])) ?></td>
                            <td class="px-2 py-1 align-middle"><?= date("M d, Y h:i A", strtotime($row['updated_at'])) ?></td>
                            <td class="px-2 py-1 align-middle"><?= $row['status']?></td>
                            <td class="px-2 py-1 align-middle text-center">
                                <a href="<?= base_url('Main/cash_advance_edit/'.$row['id']) ?>" class="mx-2 text-decoration-none text-primary"><i class="fa fa-edit"></i></a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(count($cash_advances) <= 0): ?>
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