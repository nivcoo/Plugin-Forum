<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<div class="container marge">
    <div class="row">
        <div class="col-md-10">
            <ol class="forum-breadcrumb">
                <li class="forum-breadcrumb-home">
                    <a href="/forum"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
            </ol>
        </div>
        <div class="col-md-2">
            <ol class="forum-breadcrumb">
                <?php if($perms['FORUM_VIEW_REPORT']): ?>
                    <li class="forum-left">
                        <a href="/forum/report"><i class="fa fa-flag" aria-hidden="true"></i></a>
                    </li>
                <?php endif; ?>
                <?php if($active['privatemsg']): ?>
                    <li class="forum-left">
                        <a href="/message"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                    </li>
                <?php endif; ?>
                <?php if(isset($_SESSION['user'])): ?>
                    <li class="forum-left">
                        <a href="/user/<?= $my['user']; ?>.<?= $my['id']; ?>/"><i class="fa fa-user" aria-hidden="true"></i></a>
                    </li>
                <?php endif; ?>
                <li class="forum-left last">
                    <a href="/user/logout"><i class="fa fa-sign-in" aria-hidden="true"></i></a>
                </li>
            </ol>
        </div>
    </div>

    <?= @$this->Session->flash(); ?>
    <?php foreach ($forums as $f => $forum): ?>
        <?php if($forum['Forum']['id_parent'] == 0): $p = $forum['Forum']['id']; ?>
            <div class="forum-forum">
                <div class="forum-forum-header">
                    <p class="forum-forum-title"> <?= $forum['Forum']['forum_name']; ?></p>
                </div>
            <?php foreach ($forums as $f => $forum): ?>
                <?php if($forum['Forum']['id_parent'] != 0&& $forum['Forum']['id_parent'] == $p): ?>
                    <div class="forum-category">
                        <div class="row">
                            <div class="forum-category-icone col-xs-2 col-md-1 text-center">
                                <?php if(filter_var($forum['Forum']['forum_image'], FILTER_VALIDATE_URL)): ?>
                                    <img src="<?= $forum['Forum']['forum_image']; ?>" class="forum-category-icon" alt="" />
                                <?php else: ?>
                                    <i class="fa fa-<?= $forum['Forum']['forum_image']; ?> forum-category-fa" aria-hidden="true"></i>
                                <?php endif; ?>
                            </div>
                            <div class="col-xs-7 col-md-7 col-sm-6">
                                <h3 class="forum-category-title"><a href="/forum/<?= $this->requestAction('Forum/replaceSpace/'.$forum['Forum']['forum_name']); ?>.<?= $forum['Forum']['id']; ?>/"><?= $forum['Forum']['forum_name']; ?></a></h3>
                                <div class="forum-category-description"><span>Discussions :</span> <?= $forum['Forum']['nb_discussion']; ?> <span>Message :</span> <?= $forum['Forum']['nb_message']; ?></div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-3 hidden-mob forum-category-last">
                                <?php if($forum['Forum']['nb_discussion'] != 0 && $forum['Forum']['nb_message'] != 0): ?>
                                <a href="/topic/<?= $this->requestAction('Forum/replaceSpace/'.$forum['Forum']['topic_last_title']); ?>.<?= $forum['Forum']['topic_last_id']; ?>"><?= $forum['Forum']['topic_last_title']; ?></a><br/>
                                <a style="color:#<?= $forum['Forum']['topic_last_author_color']; ?>" href="/user/<?= $forum['Forum']['topic_last_author']; ?>.<?= $forum['Forum']['topic_last_authorid']; ?>"><?= $forum['Forum']['topic_last_author']; ?></a>, <?= $forum['Forum']['topic_last_date']; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>

    <?php endforeach; ?>
    <?php if($active['statistics']): ?>
    <div class="forum-forum">
        <div class="forum-other-header">
            <p class="forum-forum-title"> Statistiques</p>
        </div>
        <div class="forum-category">
            <div class="row">
                <div class="col-md-6 col-xs-12 text-center">
                    <span class="forum-other-stats"><?= $stats['total_topic']; ?></span>
                    <span class="forum-other-stats-txt">Total Topics</span>
                </div>
                <div class="col-md-6 col-xs-12 text-center">
                    <span class="forum-other-stats"><?= $stats['total_msg']; ?></span>
                    <span class="forum-other-stats-txt">Total messages</span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if($active['useronline']): ?>
    <div class="row">
        <div class="col-md-12">
            <span>Utilisateur connecté(s) : </span>
            <?php foreach($userOnlines as $userOnline): ?>
                <a href="/user/<?= $userOnline['User']['pseudo']; ?>.<?= $userOnline['User']['id']; ?>/" style="color: #<?= $userOnline['User']['color']; ?>"><?= $userOnline['User']['pseudo']; ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>