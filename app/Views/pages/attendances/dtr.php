<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div id="printout">
    <!--print start-->
        <div class="card-header">
        <div class="d-flex w-100 justify-content-between">
                    <div class="card-title h4 mb-0 fw-bolder">Employee DTR</div>
                    <div><?= isset($employee_details['name']) ? $employee_details['name'] : '' ?></br>
                    <?= isset($employee_details['department']) ? $employee_details['department'] : '' ?></br>
                    <?= isset($employee_details['designation']) ? $employee_details['designation'] : '' ?></div>
            </div>
        </div>
        <div class="card-body">
            <p>DATE: <?=$datefrom?> - <?=$dateto?></p>
            <div class="container-fluid">
                <table class="table table-stripped table-bordered">
                    <thead>
                        <th class="p-1 text-center">Date</th>
                        <th class="p-1 text-center">In AM</th>
                        <th class="p-1 text-center">Out AM</th>
                        <th class="p-1 text-center">In PM</th>
                        <th class="p-1 text-center">Out PM</th>
                        <th class="p-1 text-center">Late(mins)<</th>
                        <th class="p-1 text-center">Undertime(mins)<</th>
                        <th class="p-1 text-center">Overtime(mins)<</th>
                    </thead>
                    <tbody>
                        <?php foreach($attendances as $row): ?>
                            <tr>
                                <td class="px-2 py-1 align-middle"><?= date("M d, Y", strtotime($row['created_at'])) ?></td>
                                <td class="px-2 py-1 align-middle"><?= ($row['time']['in_am'] != '') ? date("h:i A", strtotime($row['time']['in_am'])) : '' ?></td>
                                <td class="px-2 py-1 align-middle"><?= ($row['time']['out_am'] != '') ? date("h:i A", strtotime($row['time']['out_am'])) : '' ?></td>
                                <td class="px-2 py-1 align-middle"><?= ($row['time']['in_pm'] != '') ? date("h:i A", strtotime($row['time']['in_pm'])) : '' ?></td>
                                <td class="px-2 py-1 align-middle"><?= ($row['time']['out_pm'] != '') ? date("h:i A", strtotime($row['time']['out_pm'])) : '' ?></td>
                                <td class="px-2 py-1 align-middle"><?= $row['late'] ?></td>
                                <td class="px-2 py-1 align-middle"><?= $row['undertime'] ?></td>
                                <td class="px-2 py-1 align-middle"><?= $row['overtime'] ?></td>
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
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <table class="table table-stripped table-bordered">
                    <thead>
                        <th class="p-1 text-center">Total Working Days</th>
                        <th class="p-1 text-center">Total Late(mins)</th>
                        <th class="p-1 text-center">Total Undertime(mins)</th>
                        <th class="p-1 text-center">Total Overtime(mins)</th>
                    </thead>
                    <tbody>
                            <tr>
                                <td class="px-2 py-1 align-middle"><?=$workingdays?></td>
                                <td class="px-2 py-1 align-middle"><?=$final_late?></td>
                                <td class="px-2 py-1 align-middle"><?=$final_ut?></td>
                                <td class="px-2 py-1 align-middle"><?=$final_ot?></td>
                            </tr>
                    </tbody>
                </table>
                <div>
                </div>
            </div>
    </div>
    </div>
    <!--print end-->
    <div class="card-footer text-center">
        <button class="btn btn-sm btn-light rounded-0 border" id="print" type="button"><i class="fa fa-print"></i> Print</button>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('custom_js') ?>
<script>
    $(function(){
        $('#print').click(function(){
            var h = $('head').clone()
            var el = $('#printout').clone()

            var nw = window.open("", "_blank", "width="+($(window).width() * .8)+",left="+($(window).width() * .1)+",height="+($(window).height() * .8)+",top="+($(window).height() * .1))
                nw.document.querySelector('head').innerHTML = h.html()
                nw.document.querySelector('body').innerHTML = el.html()
                nw.document.close()
                setTimeout(() => {
                    nw.print()
                    setTimeout(() => {
                        nw.close()
                    }, 200);
                }, 300);
        })
    })
</script>
<?= $this->endSection() ?>