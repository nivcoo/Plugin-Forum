<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<div class="<?= $theme; ?> marge">
    <div class="row">
        <div class="col-md-10">
            <ol class="forum-breadcrumb">
                <li class="forum-breadcrumb-home">
                    <a href="/forum"><i class="fa fa-home" aria-hidden="true"></i></a>
                </li>
                <li class="forum-breadcrumb-child">
                    <?= $parent['forum_parent']['name']; ?>
                </li>
            </ol>
        </div>
        <div class="col-md-2">
            <?php if($isConnected): ?>
                <?php if(!$isLock OR $perms['FORUM_TOPIC_LOCK']): ?>
                    <a href="/topic/add/<?= $id; ?>" class="btn btn-theme mt30">Créer un topic</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <?= @$this->Session->flash(); ?>
    </div>

    <div class="forum-forum">
        <div class="forum-forum-header">
            <p class="forum-forum-title"> <?= $slug; ?></p>
        </div>
        <?php foreach ($forums as $f => $forum): ?>
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
                        <h3 class="forum-category-title"><a href="<?= $forum['Forum']['href']; ?>"><?= h($forum['Forum']['forum_name']); ?></a></h3>
                        <div class="forum-category-description"><span><?= $Lang->get('FORUM__FORUMS__ALT'); ?> :</span> <?= $forum['Forum']['nb_discussion']; ?> <span><?= $Lang->get('FORUM__MSG'); ?> :</span> <?= $forum['Forum']['nb_message']; ?></div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-3 hidden-mob forum-category-last">
                        <a href="<?= $forum['Forum']['forum_last_href']; ?>"><?= $forum['Forum']['forum_last_title']; ?></a><br/>
                        <a style="color:#<?= $forum['Forum']['forum_last_author_color']; ?>" href="/user/<?= $forum['Forum']['forum_last_author']; ?>.<?= $forum['Forum']['forum_last_authorid']; ?>/"><?= $forum['Forum']['forum_last_author']; ?></a>, <?= $forum['Forum']['forum_last_date']; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if(!empty($forums)): ?>
        <div class="forum-separator"><i class="fa fa-bell-o" aria-hidden="true"></i> <?= $Lang->get('FORUM__TOPIC__STICKED'); ?></div>
        <?php endif; ?>
        <?php foreach ($topics_stick as $topic_stick): ?>
            <div class="forum-category">
                <div class="row">
                    <div class="forum-category-icone col-xs-2 col-md-1 text-center">
                        <i class="fa fa-comment forum-category-fa" aria-hidden="true"></i>
                    </div>
                    <div class="col-xs-7 col-md-5 col-sm-6">
                        <div class="pull-right">
                            <i class="fa fa-thumb-tack" style="color:#348fef" aria-hidden="true"></i>
                            <?php if($topic_stick['Topic']['lock']): ?>
                                <i class="fa fa-lock" style="color:#9f191f" aria-hidden="true"></i>
                            <?php endif; ?>
                        </div>
                        <h3 class="forum-category-title"><a href="<?= $topic_stick['Topic']['href']; ?>"><?= h($topic_stick['Topic']['name']); ?></a></h3>
                        <div class="forum-category-description"><a href="/user/<?= $topic_stick['Topic']['author']; ?>.<?= $topic_stick['Topic']['id_user']; ?>/"><?= $topic_stick['Topic']['author']; ?></a>, <?= $topic_stick['Topic']['date']; ?></div>
                    </div>
                    <div class="hidden-mob col-md-2 forum-category-last">
                        <div class="forum-category-description"><span><?= $Lang->get('FORUM__MSG'); ?> :</span> <?= $topic_stick['Topic']['nb_message']; ?></div>
                        <div class="forum-category-description"><span><?= $Lang->get('FORUM__VIEW'); ?><?php if($topic_stick['Topic']['total_view'] > 1) echo 's'; ?> :</span> <?= $topic_stick['Topic']['total_view']; ?></div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-3 hidden-mob forum-category-last">
                        <a style="color:#<?= $topic_stick['Topic']['topic_last_author_color']; ?>" href="/user/<?= $topic_stick['Topic']['forum_last_author']; ?>.<?= $topic_stick['Topic']['forum_last_authorid']; ?>/"><?= $topic_stick['Topic']['forum_last_author']; ?></a>, <?= $topic_stick['Topic']['forum_last_date']; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if(!empty($topics_stick) && !empty($topics)): ?>
            <div class="forum-separator"><?= $Lang->get('FORUM__TOPICS'); ?></div>
        <?php endif; ?>
       <?php if(!empty($topics)): ?>
           <?php foreach ($topics as $topic): ?>
               <div class="forum-category">
                   <div class="row">
                       <div class="forum-category-icone col-xs-2 col-md-1 text-center">
                           <i class="fa fa-comment forum-category-fa" aria-hidden="true"></i>
                       </div>
                       <div class="col-xs-7 col-md-5 col-sm-6">
                            <?php if($topic['Topic']['lock']): ?>
                               <div class="pull-right">
                                   <i class="fa fa-lock" style="color:#9f191f" aria-hidden="true"></i>
                               </div>
                            <?php endif; ?>
                           <h3 class="forum-category-title"><a href="<?= h($topic['Topic']['href']); ?>"><?= h($topic['Topic']['name']); ?></a></h3>
                           <div class="forum-category-description"><a href="/user/<?= $topic['Topic']['author']; ?>.<?= $topic['Topic']['id_user']; ?>/"><?= $topic['Topic']['author']; ?></a>, <?= $topic['Topic']['date']; ?></div>
                       </div>
                       <div class="hidden-mob col-md-2 forum-category-last">
                           <div class="forum-category-description"><span><?= $Lang->get('FORUM__MSG'); ?> :</span> <?= $topic['Topic']['nb_message']; ?></div>
                           <div class="forum-category-description"><span><?= $Lang->get('FORUM__VIEW'); ?><?php if($topic['Topic']['total_view'] > 1) echo 's'; ?> :</span> <?= $topic['Topic']['total_view']; ?></div>
                       </div>
                       <div class="col-md-4 col-sm-4 col-xs-3 hidden-mob forum-category-last">
                           <a style="color:#<?= $topic['Topic']['topic_last_author_color']; ?>" href="/user/<?= $topic['Topic']['forum_last_author']; ?>.<?= $topic['Topic']['forum_last_authorid']; ?>/"><?= $topic['Topic']['forum_last_author']; ?></a>, <?= $topic['Topic']['forum_last_date']; ?>
                       </div>
                   </div>
               </div>
           <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?= $pagination['html']; ?>

    <?php if($isConnected): ?>
        <?php if(!$isLock OR $perms['FORUM_TOPIC_LOCK']): ?>
            <div class="row">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <div class="col-md-2">
                        <a href="/topic/add/<?= $id; ?>" class="btn btn-theme mt30"><?= $Lang->get('FORUM__TOPIC__CREATE'); ?></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>