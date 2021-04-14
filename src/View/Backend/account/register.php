
<div class="col-md-6 offset-md-3 card mt-5">
    <form class="form my-3" method="POST">

        <h3 class="text-center">Register</h3>
        <hr>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" name="username" class="form-control" placeholder="Your username...">
            <div id="error-username" class="input-error-msg err-msg-text hide"></div>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="Your password...">
            <div id="error-password" class="input-error-msg err-msg-text hide"></div>
        </div>

        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your password...">
        </div>

        <button type="submit" name="submit" id="submit" class="float-right btn btn-warning">Submit</button>

    </form>
</div>


<script type="text/javascript" src="<?= assets('js/register.js')?>" defer></script>
<script>
    var g = {
        SROOT: "<?=urlHtml('/')?>",
        registerModel: "register",
    };
</script>