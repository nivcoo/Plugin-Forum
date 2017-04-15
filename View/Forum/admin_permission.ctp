<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('FORUM__PERMISSION') ?></h3>
                </div>
                <div class="box-body">
                    <form action="" method="post" data-ajax="true">
                        <input name="data[_Token][key]" value="<?= $csrfToken ?>" type="hidden">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th><?= $Lang->get('PERMISSIONS__LABEL') ?></th>
                                    <?php foreach ($groups as $group): ?>
                                        <th class="text-center"><?= $group['Group']['group_name']; ?></th>
                                    <?php endforeach; ?>
                                    <th class="text-center"><?= $Lang->get('FORUM__USER'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; foreach ($permissions as $permission): ?>
                                <tr>
                                    <?php if($permission['ForumPermission']['name'] != $lastperm): ?>
                                        <th><?= $Lang->get($permission['ForumPermission']['name'].'__PERM'); ?></th>
                                        <?php foreach ($groups as $group): ?>
                                            <th class="text-center"><input type="checkbox" name="<?= $group['Group']['id']; ?>-<?= $permissions[$i]['ForumPermission']['id']; ?>" <?php if($permissions[$i]['ForumPermission']['value'] == 1) echo 'checked'; ?> /></th>
                                        <?php $i++; endforeach; ?>
                                        <th class="text-center"><input type="checkbox" name="99-<?= $permissions[$i]['ForumPermission']['id']; ?>" <?php if($permissions[$i]['ForumPermission']['value'] == 1) echo 'checked'; ?> /><?php $i++; ?></th>
                                    <?php endif; ?>
                                    <?php $lastperm = $permission['ForumPermission']['name']; ?>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button class="btn btn-primary pull-right" type="submit"><?= $Lang->get('GLOBAL__SUBMIT') ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>