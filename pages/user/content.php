<?php
include_once('models/database.model.php');

$result = Database::execute_query_with_prepared_statement(
    "select id_user, username, id_rank, name
    from users  where active=1 and id_user > 1 order by username",
    array()
);
?>

<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Utilisateurs</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="id-datatable-user" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Utilisateur</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <?php echo $i; ?>
                            </td>
                            <td>
                                <?php echo $row['username']; ?>
                            </td>
                            <td>
                                <?php echo $row['rolen']; ?>
                            </td>
                            <td class="project-actions text-left">
                                <a class="btn btn-info btn-sm" title="Modifier" href="#" onclick="init_form_edit_user(<?php echo $row['id_user']; ?>);">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                </a>
                                <a class="btn btn-success btn-sm" title="Changer mot de passe" href="#" onclick="init_form_change_password(<?php echo $row['id_user']; ?>);">
                                    <i class="fas fa-key">
                                    </i>
                                </a>
                                <a class="btn btn-danger btn-sm" title="Supprimer" href="#" onclick="init_form_delete_user(<?php echo $row['id_user']; ?>);">
                                    <i class="fas fa-trash">
                                    </i>
                                </a>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                </tbody>
                <!-- <tfoot>
                <tr>
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </tfoot> -->
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->

<?php
include_once('edit_user.php');
include_once('change_pass_user.php');
include_once('delete_user.php');
?>
