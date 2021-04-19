<div class="container  my-5">
    <h1 class="text-center">Sign in to Kanban</h1>
</div>
<div class="row mb-5">
    <div class="col-md-4 offset-md-4 col-sm-10 offset-sm-1 card">
        <form action="<?=urlHtml('/login/submit')?>" class="form my-3" method="post" role="alert">
            <h3 class="text-center mt-5">Login</h3>
            <hr>
            <div class="m-x5 text-center alert alert-danger input-error-msg err-msg-text hide"></div>
            <div class="row justify-content-center">
                <div class="col-md-6 form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control">
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6 form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 form-group">
                    <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me" value="On">
                    <label for="remember_me" class="form-check-label">Remember Me</label>
                </div>
            </div>

            <div class="offset-md-3 row">
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="row mt-4 float-right">
                <div class="mx-3 float-right">
                    New to Seo-Kanban?
                    <a href="<?=urlHtml('/register')?>" class="text-primary">Create an account</a>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="mb-5">&nbsp</div>

<script type="text/javascript" src="<?= assets('js/login.js')?>" defer></script>
<script>
    var g = {
        SROOT: "<?=urlHtml('/')?>",
        registerModel: "login",
    };
</script>