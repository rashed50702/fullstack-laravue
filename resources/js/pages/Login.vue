<template>
    <div>
        <div class="login-form">

            <Form>
                <div class="form-header text-center">
                    <img src="logo.png" alt="Logo">
                </div>
                <div class="form-body">
                    <div class="ivu-login-mail" placeholder="Email" data-v-3b6adb30="">
                        <div class="ivu-form-item ivu-form-item-required">
                            <div class="ivu-form-item-content">
                                <div class="ivu-input-wrapper ivu-input-wrapper-large ivu-input-type-email">
                                    <i
                                        class="ivu-icon ivu-icon-ios-loading ivu-load-loop ivu-input-icon ivu-input-icon-validate"></i>
                                    <input v-model="formData.email" autocomplete="off" spellcheck="false" type="email"
                                        class="ivu-input ivu-input-large ivu-input-with-prefix" placeholder="Email"
                                        name="mail" number="false">
                                    <span class="ivu-input-prefix"><i
                                            class="ivu-icon ivu-icon-ios-mail-outline"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ivu-form-item-content">
                        <div class="ivu-input-wrapper ivu-input-wrapper-large ivu-input-type-password">
                            <i
                                class="ivu-icon ivu-icon-ios-loading ivu-load-loop ivu-input-icon ivu-input-icon-validate"></i>
                            <input v-model="formData.password" autocomplete="off" spellcheck="false" type="password"
                                class="ivu-input ivu-input-large ivu-input-with-prefix" placeholder="Password"
                                name="password" number="false">
                            <span class="ivu-input-prefix"><i class="ivu-icon ivu-icon-ios-lock-outline"></i></span>
                        </div>
                    </div>
                    <br>
                    <Checkbox>Remember Password</Checkbox>
                </div>
                <div class="form-footer">
                    <Button type="success" long @click="handleSubmit" :disabled="isLogging"
                        :loading="isLogging">{{ isLogging ? 'Loging...' : 'Login'}}</Button>
                    <div class="pt-3">
                        <a href="#">Forgot Password?</a>
                    </div>
                </div>
            </Form>
            <div class="pt-2 divider">
                <p>Or Login with</p>
            </div>
            <div class="social-login pt-2 text-center">
                <ul>
                    <li><a href="#fb">
                            <Icon type="logo-facebook" />
                        </a></li>
                    <li><a href="#g">
                            <Icon type="logo-google" />
                        </a></li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            formData: {
                email: '',
                password: ''
            },
            isLogging: false
        };
    },

    methods: {
        async handleSubmit(){
            if (this.formData.email.trim() == '')
                return this.err('Email is required');
            if (!this.validEmail(this.formData.email))
                return this.err('Please enter a valid email address!');
            if (this.formData.password.trim() == '')
                return this.err('Password is required');
            if (this.formData.password.length < 6)
                return this.err('Incorrect credentials!');

            this.isLogging = true
            await this.callAPI('post', 'login', this.formData)
                        .then((response) => {
                            if (response.data.status === 422) {
                                let errors = response.data.errors;
                                for (let field of Object.keys(errors)) {
                                    this.err(errors[field]);
                                }
                            }else{
                                window.location = '/';
                            }
                            
                        }).catch((error) => {
                            if (error.response.status === 401){
                                this.err(error.response.data.msg);
                            }else{
                                this.err("Oops!", "Something went wrong!");
                            }
                        });
            this.isLogging = false
        },

        validEmail: function (email) {
            var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    }
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