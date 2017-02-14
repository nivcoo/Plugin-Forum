<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('FORUM__USERS') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-responsive dataTable">
                                <thead>
                                <th>Pseudo</th>
                                <th>Grade</th>
                                <th></th>
                                </thead>
                                <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $user['User']['pseudo']; ?></td>
                                        <td>
                                            <?php foreach ($user['User']['rank'] as $key => $rank): ?>
                                                <div style="background-color:#<?= $user['User']['color'][$key]; ?>;color: #fff;padding: 2px 5px;margin-top: 5px;display: inline-block;"><?= $rank; ?></div>
                                            <?php endforeach; ?>
                                        </td>
                                        <td><a href="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'edit/user/'.$user['User']['id'], 'admin' => true)) ?>" class="btn btn-primary"><?= $Lang->get('GLOBAL__EDIT'); ?></a></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>