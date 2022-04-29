<template>
    <div class="content-wrapper">
        <div class="row justify-content-end mb-3">
            <div class="col-lg-6">
                <!--  -->
            </div>
            <div class="col-lg-6 text-md-right">
                <!-- <button class="btn btn-primary" @click="showCreateForm">নতুন</button> -->
            </div>
        </div>

        <div id="page-content">
            <div class="row justify-content-center">
                <div class="col-md-6 col-sm-12">
                    <form @submit.prevent="updateProfile">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Profile</h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" v-model="profile.name">
                                    <div class="error" v-if="profile.errors.has('name')" v-html="profile.errors.get('name')" />
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" v-model="profile.email">
                                    <div class="error" v-if="profile.errors.has('email')" v-html="profile.errors.get('email')" />
                                </div>

                                <div class="form-group">
                                    <label for="email">Password</label>
                                    <h6 class="font-weight-light text-info">Please enter your password to update profile</h6>
                                    <input type="password" class="form-control" v-model="profile.password" placeholder="Please enter your password to change profile">
                                    <div class="error" v-if="profile.errors.has('password')" v-html="profile.errors.get('password')" />
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-md-6 col-sm-12">
                    <form @submit.prevent="changePassword">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Change Password</h3>
                            </div>

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" class="form-control" v-model="password.current_password">
                                    <div class="error" v-if="password.errors.has('current_password')" v-html="password.errors.get('current_password')" />
                                </div>
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" class="form-control" v-model="password.password">
                                    <div class="error" v-if="password.errors.has('password')" v-html="password.errors.get('password')" />
                                </div>
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" v-model="password.password_confirmation">
                                    <div class="error" v-if="password.errors.has('password_confirmation')" v-html="password.errors.get('password_confirmation')" />
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</template>
<script>
export default {
    data(){
        return {
            profile: new Form({
                id: '',
                name: '',
                email: '',
                password: '',
            }),

            password: new Form({
                current_password: '',
                password: '',
                password_confirmation: '', 
            }),
        }
    },
    methods: {
        async updateProfile(){
            Block.dots('#page-content');
            await this.profile.put('/api/user/update')
            .then(res=>{
                Notify.success('Update successful');
                this.logOut();
                Block.remove('#page-content');
            })
            .catch(e=>{
                console.log(e);
                Block.remove('#page-content');
            })
        },

        async changePassword(){
            Block.dots('#page-content');
            await this.password.put('/api/user/change/password')
            .then(res=>{
                Notify.success('Update successful');
                this.logOut();
                Block.remove('#page-content');
            })
            .catch(e=>{
                console.log(e);
                Block.remove('#page-content');
            })
        },

        async logOut(){
            await axios.post('/api/user/logout')
                .then(res=>{
                this.$store.commit('clearAuthData');
                this.$router.push('/login')
                })
                .catch(e=>{
                console.log(e);
            })
        }
    },
    mounted(){
        this.profile.fill(this.$store.getters.loggedInUser);
        // console.log(this.$store.getters.loggedInUser);
    }
}
</script>
<style scoped>
    .content{
        margin: -25px 0 0 -31px;
    }
</style>