<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('FORUM__INSULTS') ?></h3>
                </div>
                <div class="box-body">
                    <blockquote>
                        <p><?= $Lang->get('FORUM__PHRASE__PAGE__WORD_1'); ?></p>
                    </blockquote>
                    <p><?= $Lang->get('FORUM__PHRASE__PAGE__WORD_2'); ?><br/>
                        <?= $Lang->get('FORUM__PHRASE__PAGE__WORD_3'); ?>
                    </p>
                    <form action="" method="post" data-ajax="true">
                        <div class="ajax-msg"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-responsive">
                                    <tbody>
                                        <tr>
                                            <td><input placeholder="Mot interdit" name="word" class="form-control" type="text" /></td>
                                            <td><input placeholder="Remplacé par" name="replace" class="form-control" type="text" /></td>
                                            <td><button class="btn btn-primary" type="submit"><?= $Lang->get('GLOBAL__ADD') ?></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-responsive dataTable">
                                <thead>
                                    <tr>
                                        <th><?= $Lang->get('FORUM__WORD'); ?></th>
                                        <th><?= $Lang->get('FORUM__WORD__REPLACE'); ?></th>
                                        <th><?= $Lang->get('FORUM__ACTION'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($words as $word): ?>
                                        <tr>
                                            <td><?= $word['Insult']['word']; ?></td>
                                            <td><?= $word['Insult']['replace']; ?></td>
                                            <td><a onclick="confirmDel('/admin/forum/forum/delete/word/<?= $word['Insult']['id']; ?>')" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE') ?></a></td>
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