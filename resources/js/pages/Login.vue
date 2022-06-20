<template>
    <div>
        <div class="login-form">
            <Login>
                <div class="form-header text-center">
                    <img src="logo.png" alt="Logo">
                </div>
                <div class="form-body">
                    <Email placeholder="Email" name="email" />
                    <Password placeholder="*******" name="password" />
                    <Checkbox>Remember Password</Checkbox>
                </div>
                <div class="form-footer">
                    <Submit type="success">Login</Submit>
                    <div class="pt-3">
                        <a href="#">Forgot Password?</a>
                    </div>
                </div>
            </Login>
            <div class="pt-2 divider">
                <p>Or Login with</p>
            </div>
            <div class="social-login pt-2 text-center">
                <ul>
                    <li><a href="#fb"><Icon type="logo-facebook" /></a></li>
                    <li><a href="#g"><Icon type="logo-google" /></a></li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {

}
</script>
<style scoped>
    .form-header{
        padding-bottom: 20px;
    }
    .form-header img{
        width: 60px;
        height: 60px;
        margin: 0 auto;
    }
    .login-form{
        left: 50%;
        top: 50%;
        position: absolute;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        border: 1px solid #e9e0e0;
        border-radius: 5px;
    }
    .divider p {
        display: flex;
        flex-direction: row;
    }

    .divider p:before,
    .divider p:after {
        content: "";
        flex: 1 1;
        border-bottom: 1px solid;
        margin: auto;
    }

    .divider p:before {
        margin-right: 10px
    }

    .divider p:after {
        margin-left: 10px
    }

    .social-login ul{
        list-style-type: none;
    }

    .social-login ul li{
        display: inline;
    }
    .social-login ul li a{
        font-size: 30px;
        padding: 0px 5px;
    }

</style>