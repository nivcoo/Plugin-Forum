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
                                                    <td><input placeholder="Développeur" name="rank" class="form-control" type="text" /></td>
                                                    <td><input placeholder="Description ..." name="description" class="form-control" type="text" /></td>
                                                    <td>
                                                        <div class="form-inline">
                                                            <input style="width: 90%" type="text" placeholder="ffffff" class="form-control" name="color" />
                                                            <a target="_blank" href="http://htmlcolorcodes.com/fr/"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                                                        </div>
                                                    </td>
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
                                    <th>Nom</th>
                                    <th>Description</th>
                                    <th>Color</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                <?php foreach ($groups as $group): ?>
                                    <tr>
                                        <td><?= $group['Group']['group_name']; ?></td>
                                        <td><?= $group['Group']['group_description']; ?></td>
                                        <td><div style="background-color:#<?= $group['Group']['color']; ?>;height:16px;width:16px" ?></td>
                                        <td><a onclick="confirmDel('<?= $this->Html->url(array('controller' => 'forum', 'action' => 'delete/group/'.$group['Group']['id'], 'admin' => true)) ?>')" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE'); ?></a></td>
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