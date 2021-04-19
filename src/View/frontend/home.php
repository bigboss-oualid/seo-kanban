
<div class="container">
    <div class="jumbotron  mt-5">
        <h1 class="display-4 mt-2 text-center mt-5"><?= $titlePage; ?></h1>
        <p class="lead text-center">This is a simple Kanban Application, developed by Oualid Boulatar.</p>
        <hr class="my-4">
        <p class="text-center">To log in use the below users account or create your own account.</p>

        <?php if(!isset($user)){?>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="<?=urlHtml('/register')?>" role="button">Create Account</a>
            </p>
        <?php } ?>
    </div>
    <h2 class="my-3">Users</h2>
    <table class="table table-striped table-light mb-3">
        <caption class="text-center mb-3">
            <a href="<?= urlHtml('/login')?>">Sign up</a>
        </caption>

        <thead>
        <tr>
            <th class="font-weight-bold text-center" scope="col">USERNAME</th>
            <th class="font-weight-bold text-center" scope="col">PASSWORD</th>
            <th class="font-weight-bold text-center" scope="col">ROLE</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="text-center">Admin</td>
            <td class="text-center">Admin123-</td>
            <td class="text-center text-success font-weight-bold">Manage All boards</td>
        </tr>
        <tr>
            <td class="text-center">user</td>
            <td class="text-center">User123-</td>
            <td class="text-center text-warning font-weight-bold">Manage only his own boards</td>
        </tr>

        </tbody>
    </table>
</div>
