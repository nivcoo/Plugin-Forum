<?php if($type == 'propertiesTopic'): ?>
    <?php if($perms['FORUM_TOPIC_LOCK'] || $perms['FORUM_TOPIC_STICK'] || $perms['FORUM_TOPIC_DELETE'] || $perms['FORUM_MOOVE_TOPIC'] || $perms['FORUM_MSG_EDIT']): ?>
    <div class="modal fade" id="ModalEdit-<?= $topic['Topic']['id_topic']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel"><?= $Lang->get('FORUM__PROPERTIES'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <?php if($perms['FORUM_TOPIC_LOCK']): ?>
                            <div class="col-md-4 text-center">
                                <?php if($topic['Topic']['lock']): ?>
                                    <a href="/forum/action/topic/unlock/<?= $topic['Topic']['id_topic']; ?>" class="btn btn-theme mt30">
                                        <i class="fa fa-unlock" aria-hidden="true"></i> <?= $Lang->get('FORUM__UNLOCK'); ?>
                                    </a>
                                <?php else: ?>
                                    <a href="/forum/action/topic/lock/<?= $topic['Topic']['id_topic']; ?>" class="btn btn-theme mt30">
                                        <i class="fa fa-lock" aria-hidden="true"></i> <?= $Lang->get('FORUM__LOCK'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if($perms['FORUM_TOPIC_STICK']): ?>
                            <div class="col-md-4 text-center">
                                <?php if($topic['Topic']['stick']): ?>
                                    <a href="/forum/action/topic/unstick/<?= $topic['Topic']['id_topic']; ?>" class="btn btn-theme mt30">
                                        <i class="fa fa-paperclip" aria-hidden="true"></i> <?= $Lang->get('FORUM__UNSTICK'); ?>
                                    </a>
                                <?php else: ?>
                                    <a href="/forum/action/topic/stick/<?= $topic['Topic']['id_topic']; ?>" class="btn btn-theme mt30">
                                        <i class="fa fa-paperclip" aria-hidden="true"></i> <?= $Lang->get('FORUM__STICK'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if($perms['FORUM_TOPIC_DELETE']): ?>
                            <div class="col-md-4 text-center">
                                <a href="/forum/action/topic/delete/<?= $topic['Topic']['id_topic']; ?>" class="btn btn-theme mt30">
                                    <i class="fa fa-times" aria-hidden="true"></i> <?= $Lang->get('GLOBAL__DELETE'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if($perms['FORUM_MSG_EDIT']): ?>
                        <div class="row mt20">
                            <form action="/forum/action/topic/rename/<?= $topic['Topic']['id_topic']; ?>" method="post">
                                <input name="data[_Token][key]" value="<?= $csrfToken ?>" type="hidden" />
                                <div class="col-md-10">
                                    <input type="text" value="<?= $topic['Topic']['name']; ?>" name="name" class="form-control" />
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" class="btn btn-primary" value="<?= $Lang->get('GLOBAL__EDIT'); ?>" />
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                    <?php if($perms['FORUM_MOOVE_TOPIC']): ?>
                        <div class="row mt20">
                            <form action="/forum/action/topic/moove/<?= $topic['Topic']['id_topic']; ?>" method="post">
                                <input name="data[_Token][key]" value="<?= $csrfToken ?>" type="hidden" />
                                <div class="col-md-10">
                                    <select name="forum" class="form-control">
                                        <?php foreach($listForum as $l): ?>
                                            <option <?php if($l['Forum']['id'] == $id) echo 'selected'; ?> value="<?= $l['Forum']['id']; ?>"><?= $l['Forum']['id']; ?> : <?= $l['Forum']['forum_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" class="btn btn-primary" value="<?= $Lang->get('FORUM__MOOVE'); ?>" />
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                    <?php if($perms['FORUM_MSG_EDIT']): ?>
                        <hr />
                        <h4 class="inline"><?= $Lang->get('FORUM__SEEBY'); ?></h4>
                        <?php if(empty($topic['Topic']['individualPermission'])): ?>
                            <div class="forum-badgerank forum-topic-badgerank none"><i class="fa fa-check" aria-hidden="true"></i> <?= $Lang->get('FORUM__ALL'); ?></div>
                        <?php endif; ?>
                        <?php if(!empty($ranks)): ?>
                            <div class="row">
                                <form action="/forum/action/topic/view/<?= $topic['Topic']['id_topic']; ?>" method="post">
                                    <input name="data[_Token][key]" value="<?= $csrfToken ?>" type="hidden" />
                                    <div class="col-md-10">
                                        <?php foreach($ranks as $key => $rank): ?>
                                            <div style="background-color: #<?= $rank['Group']['color']; ?>" class="forum-badgerank"><input <?php if(isset($topic['Topic']['individualPermission'][$rank['Group']['id']]) && $topic['Topic']['individualPermission'][$rank['Group']['id']] == 'on') echo 'checked'; ?> type="checkbox" name="<?= $rank['Group']['id']; ?>" /> <?= $rank['Group']['group_name']; ?></div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="submit" class="btn btn-primary" value="<?= $Lang->get('GLOBAL__EDIT'); ?>" />
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php endif; ?>
