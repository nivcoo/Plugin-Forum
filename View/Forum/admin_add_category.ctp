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
                        <div class="form-group text-center">
                            <label class="radio-inline">
                                <input type="radio" name="ii_type" id="ii_type_icone"> Icone
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="ii_type" id="ii_type_image"> Image
                            </label>
                        </div>
                        <script type="text/javascript">
                            $("#ii_type_icone").click(function () {
                                var html = '<div class="form-group">';
                                html += '<div class="input-group">';
                                html += '<span class="input-group-addon">fa-</span>';
                                html += '<input name="image" class="form-control" type="text" placeholder="times" />';
                                html += '</div>';
                                html += '</div>';
                                $('#zone').html(html);
                            });
                            $("#ii_type_image").click(function () {
                                var html = '<div class="form-group">';
                                html += '<input name="image" class="form-control" type="text" placeholder="https://bing.com/image.png" />';
                                html += '</div>';
                                $('#zone').html(html);
                            });
                        </script>
                        <div id="zone">
                        </div>
                        <div class="form-group">
                            <input name="lock" type="checkbox" />
                            <label> <?= $Lang->get('FORUM__LOCK__CATEGORY') ?></label>
                        </div>
                        <div class="form-group">
                            <input name="automatic_lock" type="checkbox"  />
                            <label> <?= $Lang->get('FORUM__AUTOLOCK__CATEGORY') ?></label>
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