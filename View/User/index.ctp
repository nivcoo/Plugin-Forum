<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<div class="container marge">
    <div class="forum-forum">
        <div class="row">
            <div class="col-md-4">
                <div class="p15">
                    <div class="forum-bloc p15">
                        <h2 class="text-center forum-h2" style="color:#<?= $userForum['color']; ?>"> <?= $slug; ?></h2>
                        <img width="200" class="center-block topic-avatar" src="<?= $this->Html->url(array('controller' => 'API', 'action' => 'get_head_skin', 'plugin' => false, $slug, 200, 42)); ?>" alt="Avatar <?= $id; ?>" />
                        <div class="forum-rank">
                            <?php if(!empty($ranks['rank'])): ?>
                                <?php foreach($ranks['rank'] as $key => $rank): ?>
                                    <div <?= $ranks['color'][$key]; ?> class="forum-badgerank"><?= $rank; ?></div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="forum-bloc mt15">
                        <div class="forum-bloc-header p15">
                            <h3 class="forum-h3"><i class="fa fa-info-circle" aria-hidden="true"></i> <?= $Lang->get('GLOBAL__INFORMATIONS'); ?></h3>
                            <div class="forum-extrainfo">
                                <dl>
                                    <dt><?= $Lang->get('FORUM__MSG'); ?><?php if($infos['nb_message'] > 1) echo 's'; ?> :</dt>
                                    <dd><?= $infos['nb_message']; ?></dd>
                                </dl>
                                <dl>
                                    <dt><?= $Lang->get('USER__REGISTER_DATE'); ?> :</dt>
                                    <dd><?= $infos['inscription']; ?></dd>
                                </dl>
                                <dl>
                                    <dt><?= $Lang->get('FORUM__GREENTHUMB'); ?> :</dt>
                                    <dd><?= $infos['thumb']['green']; ?></dd>
                                </dl>
                                <dl>
                                    <dt><?= $Lang->get('FORUM__REDTHUMB'); ?> :</dt>
                                    <dd><?= $infos['thumb']['red']; ?></dd>
                                </dl>
                                <!-- TODO : soon update -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="p15">
                    <div class="forum-bloc p15">
                        <h5 class="inline"><?= $Lang->get('FORUM__PRESENTATION'); ?></h5>
                        <?php if(isset($_SESSION['user']) && $_SESSION['user'] == $id): ?>
                            <a class="btn-theme pull-right inline" href="edit"><i class="fa fa-pencil" aria-hidden="true"></i> <?= $Lang->get('GLOBAL__EDIT'); ?></a>
                        <?php endif; ?>
                        <div>
                            <?= $userForum['description']; ?>
                        </div>
                    </div>
                    <ul class="nav nav-tabs mt15" role="tablist">
                        <li role="presentation" class="active"><a href="#comment" aria-controls="comment" role="tab" data-toggle="tab"><?= $Lang->get('FORUM__COMMENT'); ?></a></li>
                        <li role="presentation"><a href="#thumb" aria-controls="profile" role="tab" data-toggle="tab"><?= $Lang->get('FORUM__FEEDBACK'); ?></a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="comment">
                            <h5><?= $Lang->get('FORUM__PHRASE__LASTCOMMENT'); ?></h5>
                            <?php foreach ($lasts['Comment'] as $last): ?>
                                <hr />
                                <div class="forum-profile-comment">
                                    <h4><a href="/topic/<?= $this->requestAction('Forum/replaceSpace/'.$last['Topic']['title'], ['plugin' => 'forum']); ?>.<?= $last['Topic']['id']; ?>/"><?= $last['Topic']['title']; ?></a></h4>
                                    <p><?= $this->Text->truncate($last['Topic']['content'], 150); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="thumb">
                            <h5><?= $Lang->get('FORUM__PHRASE__LASTFEEDBACK'); ?></h5>
                            <?php foreach ($lasts['Note'] as $last): ?>
                                <hr />
                                <div class="forum-profile-appreciate">
                                    <p><i class="fa fa-thumbs-<?= $last['Note']['fa']; ?> thumb-<?= $last['Note']['class']; ?>" aria-hidden="true"></i> <?= $slug.$last['Note']['txt']; ?><a href="/topic/<?= $this->requestAction('Forum/replaceSpace/'.$last['Note']['msg']['title'], ['plugin' => 'forum']); ?>.<?= $last['Note']['msg']['id']; ?>/#<?= $last['Note']['id_message']; ?>"><?= $last['Note']['message']; ?></a></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>