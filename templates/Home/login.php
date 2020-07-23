<div class="offset-4 col-4">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Login</h4>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control login-form" name="email" id="email" placeholder="you@mail.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control login-form" name="password" id="password" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    Don't have account? <a href="<?= $this->Url->build('/register') ?>" class="">Register</a>
                    <button type="button" class="btn btn-primary float-right" onclick="login()">Login</button>
                </div>
        </div>
    </div>
</div>
<script>
    function login(){
        var email = $("#email").val();
        var password = $("#password").val();
        if(isEmpty(email)){
            toastr.error('Email is required');
            return false;
        }
        if(isEmpty(password)){
            toastr.error('Password is required');
            return false;
        }
        UTILITY.ajaxSubmitDataCallback('<?= $this->Url->build('/login'); ?>',{email,password},'json',function (response) {
            if(!isEmpty(response.status) && response.status == 'error'){
                toastr.error(response.message);
            }
            else if(!isEmpty(response.status) && response.status == 'success'){
                toastr.success(response.message);
                setTimeout(function () {
                    window.location.href = '<?= $this->Url->build('/'); ?>';
                },2000);
            }
            else {
                console.error(response);
            }
        });
    }
    $(document).ready(function () {
        $(".login-form").on('keypress',function(e) {
            if(e.which == 13) {
                login();
            }
        });
    });
</script>
