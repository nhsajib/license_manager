<template>
    <div class="content-wrapper">
        <form @submit.prevent="addKey" class="mt-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="keyid">Key</label>
                                <input type="text" class="form-control" placeholder="Key" v-model="license.keyid" required>
                                <div class="error" v-if="license.errors.has('keyid')" v-html="license.errors.get('keyid')" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="username">User Name</label>
                                <input type="text" class="form-control" placeholder="User Name" v-model="license.username" required>
                                <div class="error" v-if="license.errors.has('username')" v-html="license.errors.get('username')" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select v-model="license.type" required class="form-control">
                                    <option value="">Select</option>
                                    <option value="demo">Demo</option>
                                    <option value="pro">Pro</option>
                                </select>
                                <div class="error" v-if="license.errors.has('type')" v-html="license.errors.get('type')" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button class="btn btn-outline-primary v-center">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>


        <div id="page-content">
            <div class="row justify-content-center">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">License</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 12px;">#</th>
                                            <th>Key</th>
                                            <th>User Name</th>
                                            <th>Mac</th>
                                            <th>Reg. Date</th>
                                            <th>Exp. Date</th>
                                            <th>Status</th>
                                            <th style="width: 50px;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(license, index) in licenses.data" :key="index">
                                            <td>{{ index+1 }}</td>
                                            <td>{{ license.keyid }}</td>
                                            <td>{{ license.username }}</td>
                                            <td>
                                                <span style="font-size: 1.3rem;" v-if="license.macaddress == null" class="ti-unlock text-success"></span>
                                                <span style="font-size: 1.3rem;" v-else class="ti-lock text-danger"></span>
                                            </td>
                                            <td>{{ license.create_date | DateTime }}</td>
                                            <td>{{ license.expire_date | Date }}</td>
                                            <td> 
                                                <div v-if="license.status == 1" class="badge badge-success">Active</div>
                                                <div v-else class="badge badge-danger">Deactive</div>
                                            </td>
                                            <td class="text-center">

                                                <div class="btn-group">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">Action</button>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item btn-sm" href="#" @click="renewId(license.id)">Renew ID</a>
                                                            <a class="dropdown-item btn-sm" v-if="license.status == 1" href="#" @click="deactiveId(license.id)">Deactive ID</a>
                                                            <a class="dropdown-item btn-sm" v-else href="#" @click="activeId(license.id)">Active ID</a>
                                                            <a class="dropdown-item btn-sm" v-if="$store.state.user.type == 1" href="#" @click="destroy(license.id)">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-secondary">Renew</button>
                                                    <button type="button" class="btn btn-outline-secondary">Reset</button>
                                                </div> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <pagination class="mb-0" :limit=3 :data="licenses" @pagination-change-page="get"></pagination>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            licenses: {},

            license: new Form({
                keyid: '',
                username: '',
                type: '',
            }),

            editMood: false,
        }
    },
    methods: {

        async addKey(){
            Block.dots('#page-content');
            await this.license.post('/api/license/store')
            .then(res=>{
                Notify.success('Add successful');
                this.get();
                this.license.clear();
                this.license.reset();
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

        async destroy(id){
            
            Confirm.show(
                'Confirm',
                'Do you want to delete this License?',
                'Yes',
                'No',
                () => {
                    Block.dots('#page-content');
                    axios.delete('/api/supadm/license/destroy/'+id)
                    .then(res=>{
                        Notify.success('Delete successful');
                        this.get(this.licenses.current_page)
                        Block.remove('#page-content');
                    })
                    .catch(e=>{
                        console.log(e);
                        Block.remove('#page-content');
                    })
                },
            );
        },

        async deactiveId(id){
            Block.dots('#page-content');
            await axios.put('/api/license/deactive/'+id)
            .then(res=>{
                Notify.success('Deactive successful');
                this.get(this.licenses.current_page)
                Block.remove('#page-content');
            })
            .catch(e=>{
                console.log(e);
                Block.remove('#page-content');
            })
        },

        async renewId(id){
            Block.dots('#page-content');
            await axios.put('/api/license/renew/'+id)
            .then(res=>{
                Notify.success('Deactive successful');
                this.get(this.licenses.current_page)
                Block.remove('#page-content');
            })
            .catch(e=>{
                console.log(e);
                Block.remove('#page-content');
            })
        },


        // showUpdateForm(data){
        //     this.editMood = true;
        //     this.seller.reset();
        //     this.seller.clear();
        //     this.seller.fill(data);
        //     $("#defaultModal").modal({backdrop: 'static', keyboard: false});
        // },

        async get(page){
            Block.dots('#page-content');
            await axios.get('/api/license/index?page='+page)
            .then(res=>{
                this.licenses = res.data;
                Block.remove('#page-content');
            })
            .catch(e=>{
                console.log(e);
                Block.remove('#page-content');
            })
        },

        showCreateForm(){
            this.editMood = false;
            this.seller.reset();
            this.seller.clear();
            $("#defaultModal").modal({backdrop: 'static', keyboard: false});
        }

    },
    mounted(){
        this.get();
    }
}
</script>
<style scoped>
    .content{
        margin: -25px 0 0 -31px;
    }
</style>