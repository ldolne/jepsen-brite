<?php $title = 'Admin Dashboard'; ?>

<?php ob_start(); ?>

<main role="main" class="container">

    <div class="row">
        <div class="card col-md-12 pr-1 pl-1">
                    
            <div class="card-header">
                <h2>Jepsen Brite Users</h2>
            </div>

            <ul class="list-group list-group-flush">
                <?php foreach($usersArr as $user)
                    { 
                        if($user['id'] != 51 && $user['id'] != $_SESSION['id'])
                        {?>

                    <li class="list-group-item d-flex justify-content-between">
                        <div class="d-inline-block mb-2 text-primary"><strong><?= $user['username'] ?></strong></div>
                        <div>
                            <?php if($user['isadmin'] == "0"){?>
                            <a href="./index.php?action=makeadmin&amp;id=<?= $user['id'] ?>" onclick="if(!confirm('Are you sure you want to promote this user to administrator?')) return false;" class="btn-sm btn-primary" >Promote to admin</a>
                            <?php } ?>
                            <?php if($user['isadmin'] == "1"){?>
                            <a href="./index.php?action=undoadmin&amp;id=<?= $user['id'] ?>" onclick="if(!confirm('Are you sure you want demote this user from administrator?')) return false;" class="btn-sm btn-secondary" >Demote from admin</a>
                            <?php } ?>
                            <a href="./index.php?action=admindelete&amp;id=<?= $user['id'] ?>" onclick="if(!confirm('Are you sure you want to delete this account?')) return false; " class="btn-sm btn-danger" >Delete this user</a>
                        </div>
                    </li>
                <?php
                        }
                    }
                ?>
            </ul>
        </div>
    </div><!-- /.row -->
</main><!-- /.container -->

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>