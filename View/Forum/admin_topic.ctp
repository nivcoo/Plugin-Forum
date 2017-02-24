<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('FORUM__TOPIC__ALT') ?></h3>
                </div>
                <div class="box-body">

                    <table class="table table-bordered dataTable">
                        <thead>
                        <tr>
                            <th><?= $Lang->get('GLOBAL__NAME') ?></th>
                            <th><?= $Lang->get('FORUM__AUTHOR'); ?></th>
                            <th><?= $Lang->get('FORUM__CREATE'); ?></th>
                            <th class="right"><?= $Lang->get('GLOBAL__ACTIONS') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($topics as $topic) { ?>
                            <tr>
                                <td><?= $topic['Topic']['name'] ?></td>
                                <td><?= $topic['Topic']['author']; ?></td>
                                <td><?= $topic['Topic']['date']; ?></td>
                                <td class="right">
                                    <a target="_blank" href="<?= $this->Html->url('/') ?>topic/<?= $topic['Topic']['href']; ?>/" class="btn btn-primary"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                                    <a onClick="confirmDel('<?= $this->Html->url(array('controller' => 'forum', 'action' => 'delete/topic/'.$topic['Topic']['id_topic'], 'admin' => true)) ?>')" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE') ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>