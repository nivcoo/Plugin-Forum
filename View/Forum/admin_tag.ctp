<?=  $this->Html->css('Forum.bootstrap-colorpicker.min.css'); ?>
<?=  $this->Html->css('Forum.font-awesome.min.css'); ?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('FORUM__RANK') ?></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" method="post" data-ajax="true">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="ajax-msg"></div>
                                        <div class="col-md-12">
                                            <table class="table table-responsive">
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-font" aria-hidden="true"></i>
                                                            </div>
                                                            <input placeholder="Nom du label" name="label" class="form-control" type="text" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-font-awesome" aria-hidden="true"></i>
                                                            </div>
                                                            <input placeholder="icone (exclamation-circle)" name="icon" class="form-control" type="text" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </div>
                                                            <input type="text" placeholder="#ffffff" class="form-control colorpicker-element" name="color" />
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-sort-numeric-asc" aria-hidden="true"></i>
                                                            </div>
                                                            <input placeholder="Position (1..99)" name="position" class="form-control" type="text" />
                                                        </div>
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
                                <tr>
                                    <th><?= $Lang->get('FORUM__LABEL'); ?></th>
                                    <th><?= $Lang->get('FORUM__ICON'); ?></th>
                                    <th><?= $Lang->get('FORUM__COLOR'); ?></th>
                                    <th><?= $Lang->get('FORUM__POSITION'); ?></th>
                                    <th>d</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($tags as $tag): ?>
                                    <tr>
                                        <td><?= $tag['Tag']['name']; ?></td>
                                        <td><?= $tag['Tag']['icon']; ?></td>
                                        <td>#<?= $tag['Tag']['color']; ?></td>
                                        <td><?= $tag['Tag']['position']; ?></td>
                                        <td>
                                            <span style="padding:1px 5px;color:#ffffff;font-weight:600;background-color:#<?= $tag['Tag']['color']; ?>">
                                                <?php if(!empty($tag['Tag']['icon'])): ?>
                                                    <i class="fa fa-<?= $tag['Tag']['icon']; ?>" aria-hidden="true"></i>
                                                <?php endif; ?>
                                                 <?= $tag['Tag']['name']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a onclick="confirmDel('<?= $this->Html->url(array('controller' => 'forum', 'action' => 'delete/tag/'.$tag['Tag']['id'], 'admin' => true)); ?>')" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE'); ?></a>
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
<?= $this->Html->script('Forum.bootstrap-colorpicker.min.js'); ?>
<?= $this->Html->css('dataTables.bootstrap.css'); ?>
<?= $this->Html->script('jquery.dataTables.min.js') ?>
<?= $this->Html->script('dataTables.bootstrap.min.js') ?>
<script type="text/javascript">
    $(function(){$('.colorpicker-element').colorpicker();});
</script>