<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('FORUM__RANK') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post" data-ajax="true">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ajax-msg"></div>
                                        <div class="col-md-12">
                                            <table class="table table-responsive">
                                                <tbody>
                                                <tr>
                                                    <td><input placeholder="Nom du grade (Développeur)" name="rank" class="form-control" type="text" /></td>
                                                    <td><input placeholder="Description du gade" name="description" class="form-control" type="text" /></td>
                                                    <td>
                                                        <div class="form-inline">
                                                            <input style="width: 95%" type="text" placeholder="ffffff" class="form-control" name="color" />
                                                            <a target="_blank" href="http://htmlcolorcodes.com/fr/"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                                                        </div>
                                                    </td>
                                                    <td><input placeholder="Position (1..99)" name="position" class="form-control" type="text" /></td>
                                                    <td><button class="btn btn-primary" type="submit"><?= $Lang->get('GLOBAL__ADD') ?></button> </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-responsive dataTable">
                                <thead>
                                    <tr>
                                        <th><?= $Lang->get('FORUM__RANK__ALT'); ?></th>
                                        <th><?= $Lang->get('FORUM__DESCRIPTION'); ?></th>
                                        <th><?= $Lang->get('FORUM__COLOR'); ?></th>
                                        <th><?= $Lang->get('FORUM__POSITION'); ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($groups as $group): ?>
                                    <tr>
                                        <td><?= $group['Group']['group_name']; ?></td>
                                        <td><?= $group['Group']['group_description']; ?></td>
                                        <td><div style="background-color:#<?= $group['Group']['color']; ?>;height:16px;width:16px" ?></td>
                                        <td><?= $group['Group']['position']; ?></td>
                                        <td>
                                            <a href="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'edit/rank/'.$group['Group']['id'], 'admin' => true)) ?>" class="btn btn-primary"><?= $Lang->get('GLOBAL__EDIT'); ?></a>
                                            <a onclick="confirmDel('<?= $this->Html->url(array('controller' => 'forum', 'action' => 'delete/rank/'.$group['Group']['id'], 'admin' => true)) ?>')" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE'); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?= $this->Html->css('dataTables.bootstrap.css'); ?>
                            <?= $this->Html->script('jquery.dataTables.min.js') ?>
                            <?= $this->Html->script('dataTables.bootstrap.min.js') ?>
                            <script type="text/javascript">
                                $('.dataTable').dataTable( {
                                    "paging": false
                                } );
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>