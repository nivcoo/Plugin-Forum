<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('FORUM__ADD__FORUM') ?></h3>
                </div>
                <div class="box-body">
                    <form action="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'add_forum', 'admin' => true)) ?>" method="post" data-ajax="true" data-redirect="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'forum', 'admin' => true)) ?>">
                        <div class="ajax-msg"></div>
                        <blockquote>
                            <p> Un forum est une section qui englobe les sous-forums <a href="https://i.phpierre.fr/Mineweb/Forum/help/help_forum.png" target="_blank">Voir un exemple</a></p>
                        </blockquote>
                        <div class="form-group">
                            <label><?= $Lang->get('GLOBAL__NAME') ?></label>
                            <input placeholder="Mineweb" name="name" class="form-control" type="text" />
                        </div>
                        <div class="form-group">
                            <label><?= $Lang->get('FORUM__POSITION') ?></label>
                            <select class="form-control" name="position">
                                <option value="1"><?= $Lang->get('FORUM__FIRST__POSITION') ?></option>
                                <?php foreach ($forums as $key => $forum) { ?>
                                    <option value="<?= $key+2 ?>"><?= $Lang->get('FORUM__AFTER') ?> : <?= $forum['Forum']['forum_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="pull-right">
                            <a href="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'index', 'admin' => true)) ?>" class="btn btn-default"><?= $Lang->get('GLOBAL__CANCEL') ?></a>
                            <button class="btn btn-primary" type="submit"><?= $Lang->get('GLOBAL__SUBMIT') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>