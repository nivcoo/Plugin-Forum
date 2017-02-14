<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('FORUM__INSULTS') ?></h3>
                </div>
                <div class="box-body">
                    <blockquote>
                        <p>Vous pourrez ici décider des mots interdits ainsi que l'expression par laquelle le mot doit être remplacé.</p>
                    </blockquote>
                    <p>Cet outil est un premier rempart de la modération de votre forum. Celui-ci permet de remplacer automatiquement certains mots dès qu'il y a un nouveau message ou une édition de message. <br/>
                        Cet outil n'est pas sensible aux majuscules/minuscules. Par conséquant : forum, Forum, FORUM, FoRuM sera remplacé par ce que vous avez indiqué.
                    </p>
                    <form action="" method="post" data-ajax="true">
                        <div class="ajax-msg"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-responsive">
                                    <tbody>
                                        <tr>
                                            <td><input placeholder="Mot interdit" name="word" class="form-control" type="text" /></td>
                                            <td><input placeholder="Remplacé par" name="replace" class="form-control" type="text" /></td>
                                            <td><button class="btn btn-primary" type="submit"><?= $Lang->get('GLOBAL__ADD') ?></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-responsive dataTable">
                                <thead>
                                    <th>Mot</th>
                                    <th>Remplacé par</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($words as $word): ?>
                                        <tr>
                                            <td><?= $word['Insult']['word']; ?></td>
                                            <td><?= $word['Insult']['replace']; ?></td>
                                            <td><a onclick="confirmDel('/admin/forum/forum/delete/word/<?= $word['Insult']['id']; ?>')" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE') ?></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>