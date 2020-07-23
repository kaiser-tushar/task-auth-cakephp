<table class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>E-mail</th>
        <th>Created</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!empty($users)):
        $index = $showing;
        foreach ($users as $user):
            ?>
            <tr>
                <td><?= $index++ ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td><?= $user['created'] ?></td>
            </tr>
        <?php
        endforeach;
    endif;
    ?>
    </tbody>
</table>
<?php
if($pageTotalData > 0) {
    ?>
    <div class="actions" id="report_pagination" style="text-align:right">
        <div style="float:left;margin: 10px 0;">
            Total <?= ($param['count']) ?>
            records. Showing <?= $showing ?>
            to  <?= ($pageTotalData) ?>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination mr-2 float-right">
                <?php
                if ($param['pageCount'] > 1) {
                    echo $this->Paginator->prev('Prev');
                    echo  $this->Paginator->numbers([
                        'first' => 2,
                        'modulus' => 2,
                        'last' => 2
                    ]);
                    echo $this->Paginator->next('Next');
                }
                ?>
            </ul>
        </nav>
    </div>
    <?php

}
?>

