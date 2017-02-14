<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('FORUM__ADD__CATEGORY') ?></h3>
                </div>
                <div class="box-body">
                    <form action="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'add_category', 'admin' => true)) ?>" method="post" data-ajax="true" data-redirect="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'forum', 'admin' => true)) ?>">
                        <div class="ajax-msg"></div>
                        <div class="form-group">
                            <label><?= $Lang->get('GLOBAL__NAME') ?></label>
                            <input placeholder="Mineweb" name="name" class="form-control" type="text" />
                        </div>
                        <div class="form-group">
                            <label><?= $Lang->get('FORUM__POSITION') ?></label>
                            <input value="<?= $datas['Forum']['position']; ?>" name="position" class="form-control" type="text" />
                        </div>
                        <div class="form-group">
                            <label><?= $Lang->get('FORUM__PARENT') ?></label>
                            <select class="form-control" name="parent">
                                <?php foreach ($forums as $key => $forum) { ?>
                                    <option value="<?= $forum['Forum']['id']; ?>" <?php if($forum['Forum']['id'] == $datas['Forum']['id_parent']) echo 'selected'; ?>><?= $Lang->get('FORUM__IN') ?> : <?= $forum['Forum']['forum_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?= $Lang->get('GLOBAL__IMAGE') ?> <a style="font-size: 9px" target="_blank" href="http://fontawesome.io/cheatsheet/"><i class="fa fa-question-circle" aria-hidden="true"></i></a></label>
                            <div class="input-group">
                                <span class="input-group-addon">fa-</span>
                                <input value="<?= $datas['Forum']['forum_image']; ?>" name="image" class="form-control" type="text" />
                            </div>
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