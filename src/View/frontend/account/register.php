<div class="container  my-5">
    <h1 class="text-center">Create an Account</h1>
</div>
<div class="row mb-5">
    <div class="col-md-4 offset-md-4 col-sm-10 offset-sm-1 card">
        <form class="form my-3" method="POST">

            <h3 class="text-center">Register</h3>
            <hr>

            <div class="row justify-content-center">
                <div class="col-md-6 form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" name="username" class="form-control" placeholder="Your username...">
                    <div id="error-username" class="input-error-msg err-msg-text hide"></div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6 form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Your password...">
                    <div id="error-password" class="input-error-msg err-msg-text hide"></div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6 form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your password...">
                </div>
            </div>

            <div class="offset-md-3 row">
                <button type="submit" name="submit" id="submit" class="float-right btn btn-warning">Submit</button>
            </div>

    </form>
</div>


<script type="text/javascript" src="<?= assets('js/register.js')?>" defer></script>
<script>
    var g = {
        SROOT: "<?=urlHtml('/')?>",
        registerModel: "register",
    };
</script>