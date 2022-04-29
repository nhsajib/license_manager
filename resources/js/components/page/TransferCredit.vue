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
                    <form @submit.prevent="transferCredit">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Transfe Key</h3>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="type">Select Seller</label>
                                    <v-select :options="users" v-model="transfer.user_id" label="email" :reduce="email => email.id" :clearable="false" :selectOnTab="true">
                                        <template #search="{attributes, events}">
                                            <input
                                            class="vs__search"
                                            v-bind="attributes"
                                            v-on="events"
                                            />
                                        </template>
                                        <template v-slot:option="user">
                                            {{ user.email }}
                                        </template>
                                    </v-select>
                                </div>
                                <div class="form-group">
                                    <label for="credit">Credit</label>
                                    <input type="number" v-model="transfer.credit" class="form-control" placeholder="Credit" required>
                                    <div class="error" v-if="transfer.errors.has('credit')" v-html="transfer.errors.get('credit')" />
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2 btn-block">Transfer</button>
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
            users: [],
            
            transfer: new Form({
                user_id: '',
                credit: '',
            }),
        }
    },
    methods: {

        async transferCredit(){
            Block.dots('#page-content');
            await this.transfer.post('/api/credit/transfer')
            .then(res=>{
                Notify.success('Transfer successful');
                this.transfer.credit = '';
                Block.remove('#page-content');
            })
            .catch(e=>{
                if(typeof e.response.data.status !== 'undefined'){
                    Notify.failure(e.response.data.message);
                }
                console.log(e);
                Block.remove('#page-content');
            })
        },

        async getUsers(){
            Block.dots('#page-content');
            await axios.get('/api/users/all')
            .then(res=>{
                this.users = res.data;
                Block.remove('#page-content');
            })
            .catch(e=>{
                console.log(e);
                Block.remove('#page-content');
            })
        },

    },
    mounted(){
        this.getUsers();
    }
}
</script>
<style scoped>
    .content{
        margin: -25px 0 0 -31px;
    }
</style>