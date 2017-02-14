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
                            <?php foreach($ranks['rank'] as $key => $rank): ?>
                                <div <?= $ranks['color'][$key]; ?> class="forum-badgerank"><?= $rank; ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="forum-bloc mt15">
                        <div class="forum-bloc-header p15">
                            <h3 class="forum-h3"><i class="fa fa-info-circle" aria-hidden="true"></i> Informations</h3>
                            <div class="forum-extrainfo">
                                <dl>
                                    <dt>Message<?php if($infos['nb_message'] > 1) echo 's'; ?> :</dt>
                                    <dd><?= $infos['nb_message']; ?></dd>
                                </dl>
                                <dl>
                                    <dt>Inscription :</dt>
                                    <dd><?= $infos['inscription']; ?></dd>
                                </dl>
                                <dl>
                                    <dt>Pouce vert :</dt>
                                    <dd><?= $infos['thumb']['green']; ?></dd>
                                </dl>
                                <dl>
                                    <dt>Pource rouge :</dt>
                                    <dd><?= $infos['thumb']['red']; ?></dd>
                                </dl>
                                <!--
                                <dl>
                                    <dt>Twitter</dt>
                                    <dd><?php //echo $infos['social']['twitter']; ?></dd>
                                </dl>
                                -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="p15">
                    <div class="forum-bloc p15">
                        <h5>Présentation</h5>
                        <?= $userForum['description']; ?>
                    </div>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mt15" role="tablist">
                        <li role="presentation" class="active"><a href="#comment" aria-controls="comment" role="tab" data-toggle="tab">Commentaire</a></li>
                        <li role="presentation"><a href="#thumb" aria-controls="profile" role="tab" data-toggle="tab">Appréciations</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="comment">
                            <h5>Derniers commentaires</h5>
                            <?php foreach ($lasts['Comment'] as $last): ?>
                                <hr />
                                <div class="forum-profile-comment">
                                    <h4><a href="/topic/<?= $this->requestAction('Forum/replaceSpace/'.$last['Topic']['title'], ['plugin' => 'forum']); ?>.<?= $last['Topic']['id']; ?>/"><?= $last['Topic']['title']; ?></a></h4>
                                    <p><?= $this->Text->truncate($last['Topic']['content'], 150); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="thumb">
                            <h5>Dernières appréciations</h5>
                            <?php foreach ($lasts['Note'] as $last): ?>
                                <hr />
                                <div class="forum-profile-appreciate">
                                    <p><i class="fa fa-thumbs-<?= $last['Note']['fa']; ?> thumb-<?= $last['Note']['class']; ?>" aria-hidden="true"></i> <?= $slug.$last['Note']['txt']; ?><a href="/topic/<?= $this->requestAction('Forum/replaceSpace/'.$last['Note']['msg']['title'], ['plugin' => 'forum']); ?>.<?= $last['Note']['msg']['id']; ?>#<?= $last['Note']['id_message']; ?>"><?= $last['Note']['message']; ?></a></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>