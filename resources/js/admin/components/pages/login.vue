<template>
    <div>
        <div class="container">
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
                <div class="login_header">
                    <h1>Login Page</h1>
                </div>
                <Input type="email" v-model="data.email" class="mb-3" placeholder="Email" />
                <Input type="password" v-model="data.password" class="mb-3" placeholder="Password" />
                <div class="login_footer">
                    <Button type="primary" @click="login" :disabled="isLogging" :loading="isLogging">{{isLogging ? 'Loging...' : 'Login'}}</Button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "login",
    data(){
        return {
            data: {
                email: '',
                password: '',
            },
            isLogging: false
        }
    },
    methods: {
        async login(){
            if(this.data.email.trim()==='') return this.error('Email is required')
            if(this.data.password.trim()==='') return this.error('Password is required')
            if(this.data.password.length < 6) return this.error('Password is more than 6 characters')
            this.isLogging = true
            const res = await this.callApi('post', 'api/app/admin_login', this.data)
            if(res.status === 200){
                this.success(res.data.msg)
                window.location = '/'
            } else {
                if (res.status === 401){
                    this.error(res.data.msg)
                } else if (res.status === 422) {
                    for (let i in res.data.errors){
                        this.error(res.data.errors[i])
                    }
                } else {
                    this.swr()
                }
            }
            this.isLogging = false
        }
    }
}
</script>

<style scoped>
 ._1adminOverveiw_table_recent{
     margin: 0 auto;
     margin-top: 220px;
 }
 .login_footer{
     margin: 0 auto;
     text-align: center;
 }
 .login_header{
     text-align: center;
     margin-bottom: 25px;
 }
</style>
