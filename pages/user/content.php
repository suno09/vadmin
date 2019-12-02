<?php
include_once('models/database.model.php');

$result = Database::execute_query_with_prepared_statement(
    "select id_user, username, role, 
    case role 
    when 1 then 'ADMIN'
    when 2 then 'GERANT'
    when 3 then 'VENDEUR' end as rolen
    from users where active=1 and id_user > 1 order by username",
    array()
);
?>

<section class="content">
    <!-- Default box -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Utilisateurs</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 5%">
                            #
                        </th>
                        <th style="width: 35%">
                            Utilisateur
                        </th>
                        <th style="width: 20%">
                            Role
                        </th>
                        <th>
                            Actions
                        </th>
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
            </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Footer
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->

<?php
include_once('edit_user.php');
include_once('change_pass_user.php');
include_once('delete_user.php');
?>