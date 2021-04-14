<div class="col-md-6 offset-md-3 card mt-5">
    <form class="form my-3" action="<?=urlHtml('/login/submit')?>" method="post">
        <?php if (!empty($errors)): ?>
            <div class="text-danger font-weight-bold alert-warning p-2 border border-danger rounded">
                <?php
                    echo "<p>$errors</p>";
                ?>
            </div>
        <?php endif; ?>
        <h3 class="text-center">Login</h3>
        <hr>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="text" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
            <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me" value="on">
            <label for="remember_me" class="form-check-label">Remember Me</label>
        </div>

        <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>

        <div class="text-right">
            <a href="<?=urlHtml('/register')?>" class="text-primary">Register</a>
        </div>
    </form>
</div>