<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('FORUM__MSGREPORT') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <blockquote>
                                Les modérateurs peuvent accéder à cette section depuis cette page : <a href="/forum/report">ici</a>
                            </blockquote>
                            <table class="table table-responsive dataTable">
                                <thead>
                                <th>Pseudo</th>
                                <th>Par</th>
                                <th>Date</th>
                                <th>Content</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                <?php foreach ($msgreports as $msgreport): ?>
                                    <tr>
                                        <td><?= $msgreport['MsgReport']['user']; ?></td>
                                        <td><?= $msgreport['MsgReport']['date']; ?></td>
                                        <td><?= $msgreport['MsgReport']['reason']; ?></td>
                                        <td><?= $msgreport['MsgReport']['content']; ?></td>
                                        <td>
                                            <a href="/topic/<?= $msgreport['MsgReport']['href']; ?>/#<?= $msgreport['MsgReport']['id_msg']; ?>" class="btn btn-info"><i class="fa fa-external-link" aria-hidden="true"></i></a>
                                            <a onClick="confirmDel('<?= $this->Html->url(array('controller' => 'forum', 'action' => 'delete/report/'.$msgreport['MsgReport']['id'], 'admin' => true)) ?>')" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE') ?></a>
                                        </td>
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