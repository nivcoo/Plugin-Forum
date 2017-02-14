<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if($type == 'forum'): ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $Lang->get('FORUM__EDIT__FORUM') ?></h3>
                    </div>
                    <div class="box-body">
                        <form action="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'admin_edit', 'admin' => true)) ?>" method="post" data-ajax="true" data-redirect="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'admin_edit', 'admin' => true)) ?>">
                            <div class="ajax-msg"></div>
                            <div class="form-group">
                                <label><?= $Lang->get('GLOBAL__NAME') ?></label>
                                <input value="<?= $datas['forum_name']; ?>" name="name" class="form-control" type="text" />
                                <input value="<?= $datas['id']; ?>" name="id" type="hidden" />
                            </div>
                            <div class="form-group">
                                <label><?= $Lang->get('FORUM__POSITION') ?></label>
                                <select class="form-control" name="position">
                                    <option value="1"><?= $Lang->get('FORUM__FIRST__POSITION') ?></option>
                                    <?php foreach ($forums as $key => $forum) { ?>
                                        <option value="<?= $key+2 ?>" <?php if($key+2 == $datas['position']) echo 'selected'; ?> <?php if($key+1 == $datas['position']) echo 'disabled'; ?>><?= $Lang->get('FORUM__AFTER') ?> : <?= $forum['Forum']['forum_name'] ?></option>
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
            <?php elseif ($type == 'category'): ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $Lang->get('FORUM__EDIT__CATEGORY') ?></h3>
                    </div>
                    <div class="box-body">
                        <form action="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'admin_edit', 'admin' => true)) ?>" method="post" data-ajax="true" data-redirect="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'admin_edit', 'admin' => true)) ?>">
                            <div class="ajax-msg"></div>
                            <div class="form-group">
                                <label><?= $Lang->get('GLOBAL__NAME') ?></label>
                                <input value="<?= $datas['Forum']['forum_name']; ?>" name="name_category" class="form-control" type="text" />
                                <input value="<?= $datas['Forum']['id']; ?>" name="id" type="hidden" />
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
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><?= $Lang->get('GLOBAL__SUBMIT'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php elseif ($type == 'user'): ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $Lang->get('FORUM__EDIT__USER') ?></h3>
                    </div>
                    <div class="box-body">
                        <form action="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'admin_edit', 'admin' => true)) ?>" method="post" data-ajax="true" data-redirect="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'admin_edit', 'admin' => true)) ?>">
                            <div class="ajax-msg"></div>
                            <div class="form-group">
                                <label>Pseudo</label>
                                <input type="hidden" name="idgroup" value="<?= $datas['rank']['r']; ?>" />
                                <input type="hidden" name="useredit" value="<?= $datas['user']['id']; ?>" />
                                <input class="form-control" type="text" value="<?= $datas['user']['username']; ?>" disabled />
                            </div>
                            <table class="table table-responsive dataTable">
                                <thead>
                                <th>Groupe</th>
                                <th>Dominance</th>
                                <th>Grade</th>
                                </thead>
                                <tbody>
                                <?php foreach ($datas['rank']['rank'] as $key => $rank): ?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="rank_<?= $rank['Group']['id']; ?>"<?php if(!empty($datas['rank']['rankbis'])){foreach ($datas['rank']['rankbis'] as $d){if($d['id'] == $rank['Group']['id']) echo 'checked';}} ?> />
                                        </td>
                                        <td><input type="radio" <?php if (!empty($datas['rank']['domin'][0]['Groups_user']['domin']) && $datas['rank']['domin'][0]['Groups_user']['id_group'] == $rank['Group']['id']) echo 'checked'; ?> name="domin" value="<?= $rank['Group']['id']; ?>" /> </td>
                                        <td><div style="background-color:#<?= $rank['Group']['color']; ?>;color: #fff;padding: 2px 5px;margin-top: 5px;display: inline-block"><?= $rank['Group']['group_name']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" rows="3"><?= $datas['profile']['description']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Dernier passage sur le forum</label>
                                <input class="form-control" type="text" value="<?= $datas['user']['lastseen']; ?>" disabled />
                            </div>
                            <!-- Soon update-->
                            <!-- last action histoires -->
                            <!-- Signalement list tableau -->
                            <!-- stats : thumb / nb message / nbtopic / isbanned / social network -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><?= $Lang->get('GLOBAL__SUBMIT'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>