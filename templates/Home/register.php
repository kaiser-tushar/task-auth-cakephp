<div class="offset-4 col-4">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Register</h4>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="you@mail.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-primary float-right" onclick="register()">Register</button>
                </div>
        </div>
    </div>
</div>
<script>
    function register(){
        var name = $("#name").val();
        var email = $("#email").val();
        var password = $("#password").val();
        if(isEmpty(name)){
            toastr.error('Name is required');
            return false;
        }
        if(isEmpty(email)){
            toastr.error('Email is required');
            return false;
        }
        if(isEmpty(password)){
            toastr.error('Password is required');
            return false;
        }
        UTILITY.ajaxSubmitDataCallback('<?= $this->Url->build('/register'); ?>',{name,email,password},'json',function (response) {
            if(!isEmpty(response.status) && response.status == 'error'){
                toastr.error(response.message);
            }
            else if(!isEmpty(response.status) && response.status == 'success'){
                toastr.success(response.message);
                setTimeout(function () {
                    window.location.href = '<?= $this->Url->build('/login'); ?>';
                },2000);
            }
            else {
                console.error(response);
            }
        })
    }
</script>
