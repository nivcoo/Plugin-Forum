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
                                    html += '<input value="<?= $datas["Forum"]["forum_image"]; ?>" name="image" class="form-control" type="text" placeholder="times" />';
                                    html += '</div>';
                                    html += '</div>';
                                    $('#zone').html(html);
                                });
                                $("#ii_type_image").click(function () {
                                    var html = '<div class="form-group">';
                                    html += '<input value="<?= $datas["forum"]["forum_image"]; ?>" name="image" class="form-control" type="text" placeholder="https://bing.com/image.png" />';
                                    html += '</div>';
                                    $('#zone').html(html);
                                });
                            </script>
                            <div id="zone">
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
                        <script type="text/javascript">
                            function icone() {
                                var html = '<div class="form-group">';
                                html += '<div class="input-group">';
                                html += '<span class="input-group-addon">fa-</span>';
                                html += '<input value="<?= $datas["Forum"]["forum_image"]; ?>" name="image" class="form-control" type="text" placeholder="times" />';
                                html += '</div>';
                                html += '</div>';
                                $('#zone').html(html);
                            }
                            function image() {
                                var html = '<div class="form-group">';
                                html += '<input value="<?= $datas["Forum"]["forum_image"]; ?>" name="image" class="form-control" type="text" placeholder="https://bing.com/image.png" />';
                                html += '</div>';
                                $('#zone').html(html);
                            }
                        </script>
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
                            </div>
                            <div class="form-group text-center">
                                <label class="radio-inline">
                                    <?php if(!filter_var($datas["Forum"]["forum_image"], FILTER_VALIDATE_URL)): ?>
                                        <input checked type="radio" name="ii_type" id="ii_type_icone"> Icone
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                icone();
                                            });
                                        </script>
                                    <?php else: ?>
                                        <input type="radio" name="ii_type" id="ii_type_icone"> Icone
                                    <?php endif; ?>
                                </label>
                                <label class="radio-inline">
                                    <?php if(filter_var($datas["Forum"]["forum_image"], FILTER_VALIDATE_URL)): ?>
                                        <input checked type="radio" name="ii_type" id="ii_type_image"> Image
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                image();
                                            });
                                        </script>
                                    <?php else: ?>
                                        <input type="radio" name="ii_type" id="ii_type_image"> Image
                                    <?php endif; ?>
                                </label>
                            </div>
                            <script type="text/javascript">
                                $("#ii_type_icone").click(function () {
                                    icone();
                                });
                                $("#ii_type_image").click(function () {
                                    image();
                                });
                            </script>
                            <div id="zone">
                            </div>

                            <div class="form-group">
                                <input name="lock" id="lock" type="checkbox" <?= ($datas['Forum']['lock']) ? 'checked' : ''; ?>  />
                                <label for="lock"> <?= $Lang->get('FORUM__LOCK__CATEGORY') ?></label>
                            </div>
                            <div class="form-group">
                                <input name="automatic_lock" id="automatic_lock" type="checkbox" <?= ($datas['Forum']['automatic_lock']) ? 'checked' : ''; ?>  />
                                <label for="automatic_lock"> <?= $Lang->get('FORUM__AUTOLOCK__CATEGORY') ?></label>
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
                                <label><?= $Lang->get('FORUM__PSEUDO'); ?></label>
                                <input type="hidden" name="idgroup" value="<?= $datas['rank']['r']; ?>" />
                                <input type="hidden" name="useredit" value="<?= $datas['user']['id']; ?>" />
                                <input class="form-control" type="text" value="<?= $datas['user']['username']; ?>" disabled />
                            </div>
                            <table class="table table-responsive dataTable">
                                <thead>
                                    <tr>
                                        <th><?= $Lang->get('FORUM__GROUP'); ?></th>
                                        <th><?= $Lang->get('FORUM__DOMINANCE'); ?></th>
                                        <th><?= $Lang->get('FORUM__RANK__ALT'); ?></th>
                                    </tr>
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
                                <label><?= $Lang->get('FORUM__DESCRIPTION'); ?></label>
                                <textarea class="form-control" name="description" rows="3"><?php if(isset($datas['profile']['description'])) echo $datas['profile']['description']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label><?= $Lang->get('FORUM__LAST__PASSAGE'); ?></label>
                                <input class="form-control" type="text" value="<?= $datas['user']['lastseen']; ?>" disabled />
                            </div>
                            <!-- TODO : Soon update-->
                            <!-- stats : thumb / nb message / nbtopic / isbanned / dessus description social network -->
                            <!-- Premier bloc stats / -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><?= $Lang->get('GLOBAL__SUBMIT'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $Lang->get('FORUM__SOCIAL__NETWORK') ?></h3>
                    </div>
                    <div class="box-body">
                        <form action="" method="post" data-ajax="true">
                            <div class="ajax-msg"></div>
                            <div class="form-group">
                                <label><?= $Lang->get('FORUM__SOCIAL__FACEBOOK'); ?></label>
                                <input class="form-control" type="text" name="facebook" value="<?= $socialNetworks['facebook']; ?>" />
                                <input class="form-control" type="hidden" name="social" value="social" />
                            </div>
                            <div class="form-group">
                                <label><?= $Lang->get('FORUM__SOCIAL__TWITTER'); ?></label>
                                <input class="form-control" type="text" name="twitter" value="<?= $socialNetworks['twitter']; ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $Lang->get('FORUM__SOCIAL__YOUTUBE'); ?></label>
                                <input class="form-control" type="text" name="youtube" value="<?= $socialNetworks['youtube']; ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $Lang->get('FORUM__SOCIAL__GOOGLEPLUS'); ?></label>
                                <input class="form-control" type="text" name="googleplus" value="<?= $socialNetworks['googleplus']; ?>" />
                            </div>
                            <div class="form-group">
                                <label><?= $Lang->get('FORUM__SOCIAL__SNAPCHAT'); ?></label>
                                <input class="form-control" type="text" name="snapchat" value="<?= $socialNetworks['snapchat']; ?>" />
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><?= $Lang->get('GLOBAL__SUBMIT'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $Lang->get('FORUM__LAST__ACTIVITY') ?></h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive dataTable">
                            <thead>
                                <tr>
                                    <th><?= $Lang->get('FORUM__DATE__ACTIVITY'); ?></th>
                                    <th><?= $Lang->get('FORUM__IP'); ?></th>
                                    <th><?= $Lang->get('FORUM__CATEGORY__ALT'); ?></th>
                                    <th><?= $Lang->get('FORUM__ACTION'); ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($history as $key => $h): ?>
                                <tr>
                                    <td><?= $h['Historie']['date']; ?></td>
                                    <td><?= $h['Historie']['ip']; ?></td>
                                    <td><?= $h['Historie']['category']; ?></td>
                                    <td><?= $h['Historie']['action']; ?></td>
                                    <td><?= $h['Historie']['content']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $Lang->get('FORUM__LAST__REPORT') ?></h3>
                        <p><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?= $Lang->get('FORUM__PHRASE__PAGE__ADMINEDIT_1'); ?></p>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive dataTable">
                            <thead>
                                <tr>
                                    <th><?= $Lang->get('FORUM__DATE__REPORT'); ?></th>
                                    <th><?= $Lang->get('FORUM__REASON'); ?></th>
                                    <th<?= $Lang->get('FORUM__ACTION'); ?></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($msgReport as $key => $m): ?>
                                <tr>
                                    <td><?= $m['MsgReport']['date']; ?></td>
                                    <td><?= $m['MsgReport']['reason']; ?></td>
                                    <td><?= $m['MsgReport']['content']; ?></td>
                                    <td><a  href="/topic/<?= $m['MsgReport']['href']; ?>/#<?= $m['MsgReport']['id_msg']; ?>" class="btn btn-info"><i class="fa fa-external-link" aria-hidden="true"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?= $this->Html->css('dataTables.bootstrap.css'); ?>
            <?= $this->Html->script('jquery.dataTables.min.js') ?>
            <?= $this->Html->script('dataTables.bootstrap.min.js') ?>
            <script type="text/javascript">
                $('.dataTable').dataTable( {
                    "paging": false
                } );
            </script>
            <?php elseif($type == 'rank'): ?>
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?= $Lang->get('FORUM__EDIT__RANK') ?></h3>
                        <p class="pull-right"><a href="/admin/forum/forum/rank"><i class="fa fa-undo" aria-hidden="true"></i> <?= $Lang->get('FORUM__BACKTO__RANK'); ?></a></p>
                    </div>
                    <div class="box-body">
                        <form action="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'admin_edit', 'admin' => true)) ?>" method="post" data-ajax="true" data-redirect="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'admin_edit', 'admin' => true)) ?>">
                            <div class="ajax-msg"></div>
                            <div class="form-group">
                                <label><?= $Lang->get('GLOBAL__NAME') ?></label>
                                <input value="<?= $datas['group_name']; ?>" placeholder="Développeur" name="name" class="form-control" type="text" />
                                <input value="<?= $datas['id']; ?>" name="id" type="hidden" />
                            </div>
                            <div class="form-group">
                                <label><?= $Lang->get('FORUM__DESCRIPTION') ?></label>
                                <input value="<?= $datas['group_description']; ?>" placeholder="Description du groupe" name="description" class="form-control" type="text" />
                            </div>
                            <div class="form-group">
                                <label><?= $Lang->get('FORUM__COLOR') ?></label>
                                <div class="row">
                                    <div class="col-md-11">
                                        <input value="<?= $datas['color']; ?>" name="color" class="form-control" type="text" />
                                    </div>
                                    <div class="col-md-1">
                                        <a target="_blank" href="http://htmlcolorcodes.com/fr/"><i class="fa fa-question-circle" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?= $Lang->get('FORUM__POSITION') ?></label>
                                <input value="<?= $datas['position']; ?>" placeholder="Position ( 1 à 99 )" name="position" class="form-control" type="text" />
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary"><?= $Lang->get('GLOBAL__EDIT'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
