<?= $this->Html->css('Forum.forum-style.css?'.rand(1, 1000000)) ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center banned">Vous êtes banni !</h1>
            <p class="text-center">Vous avez été banni jusqu'au <?= $infos['date']; ?> par <?= $infos['user']; ?> pour la raison suivante :</p>
            <p class="text-center">
                <i class="fa fa-quote-left fa-2x" aria-hidden="true"></i> <span class="padding-banned"><?= $infos['reason']; ?></span> <i class="fa fa-quote-right fa-2x" aria-hidden="true"></i>
            </p>
        </div>
    </div>
</div>