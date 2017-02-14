<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('FORUM__PERMISSION') ?></h3>
                </div>
                <div class="box-body">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="" method="post" data-ajax="true">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="ajax-msg"></div>
                                            <div class="col-md-12">
                                                <blockquote>
                                                    Cet outil est très pratique lorsque vous ajoutez des nouveaux grades et que vous voulez leur donner des permissions. Par défaut, l'accès est restreint si aucune permission n'est configuré pour le groupe.
                                                </blockquote>
                                                <table class="table table-responsive">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <select name="rank" class="form-control">
                                                                <?php foreach ($groups as $group): ?>
                                                                    <option value="<?= $group['Group']['id']; ?>"><?= $group['Group']['group_name']; ?></option>
                                                                <?php endforeach; ?>
                                                                <option value="99"><?= $Lang->get('FORUM__RANK__BASIC'); ?></option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="permission" class="form-control">
                                                                <?php foreach ($permissions as $permission): ?>
                                                                    <?php if($permission['ForumPermission']['name'] != $lastperm): ?>
                                                                        <option value="<?= $permission['ForumPermission']['name']; ?>"><?= $Lang->get($permission['ForumPermission']['name'].'__PERM'); ?></option>
                                                                    <?php endif; ?>
                                                                    <?php $lastperm = $permission['ForumPermission']['name']; ?>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="access" class="form-control">
                                                                <option selected disabled value="2">Autoriser ?</option>
                                                                <option value="0">Non</option>
                                                                <option value="1">Oui</option>
                                                            </select>
                                                        </td>
                                                        <td><button class="btn btn-primary" type="submit"><?= $Lang->get('GLOBAL__ADD') ?></button> </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-responsive dataTable">
                                <thead>
                                <th>Groupe</th>
                                <th>Permission</th>
                                <th>Permission#data</th>
                                <th>Color</th>
                                <th></th>
                                </thead>
                                <tbody>
                                <?php foreach ($permissions as $permission): ?>
                                    <tr>
                                        <td><?= $permission['ForumPermission']['group_name']; ?></td>
                                        <td><?= $Lang->get($permission['ForumPermission']['name'].'__PERM'); ?></td>
                                        <td><?= $permission['ForumPermission']['name']; ?></td>
                                        <td><?= $permission['ForumPermission']['state']; ?></td>
                                        <td>
                                            <a href="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'switch/permission/'.$permission['ForumPermission']['id'], 'admin' => true)) ?>" class="btn btn-primary"><?= $Lang->get('FORUM__SWITCH'); ?></a>
                                            <a href="<?= $this->Html->url(array('controller' => 'forum', 'action' => 'delete/permission/'.$permission['ForumPermission']['id'], 'admin' => true)) ?>" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE'); ?></a>
                                        </td>
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