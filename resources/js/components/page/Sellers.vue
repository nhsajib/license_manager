<template>
    <div class="content-wrapper">
        <div class="row justify-content-end mb-3">
            <div class="col-lg-6">
                <!--  -->
            </div>
            <div class="col-lg-6 text-md-right">
                <button class="btn btn-primary" @click="showCreateForm">New</button>
            </div>
        </div>

        <div id="page-content">
            <div class="row justify-content-center">
                <div class="col-md-10 col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sellers</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 12px;">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                            <th>Credit</th>
                                            <th style="width: 50px;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(seller, index) in sellers.data" :key="index">
                                            <td>{{index+1}}</td>
                                            <td> <router-link :to="'/supadm/license/of/seller/'+seller.id"> {{seller.name}} </router-link> </td>
                                            <td>{{seller.email}}</td>
                                            <td> 
                                                <div v-if="seller.status == 1" class="badge badge-success">Active</div>
                                                <div v-else class="badge badge-danger">Deactive</div>
                                            </td>
                                            <td>{{ ((+seller.credit_sum_credit) - (+seller.credit_uses_sum_credit)) }}</td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">Action</button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item btn-sm" href="#" @click="showUpdateForm(seller)">Edit</a>
                                                        <!-- <a class="dropdown-item btn-sm" href="#" @click="destroy(land.id)">ডিলিট</a> -->
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <pagination class="mb-0" :limit=3 :data="sellers" @pagination-change-page="get"></pagination>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog" aria-labelledby="defaultModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="form" @submit.prevent="">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title py-2" v-if="!editMood">New Seller</h4>
                            <h4 class="card-title py-2" v-if="editMood">Update Seller</h4>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" v-model="seller.name" id="name"/>
                                <div class="error" v-if="seller.errors.has('name')" v-html="seller.errors.get('name')" />
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" v-model="seller.email" id="email"/>
                                <div class="error" v-if="seller.errors.has('email')" v-html="seller.errors.get('email')" />
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <h6 v-if="editMood" class="font-weight-light text-info">If don't want to change the password, leave it empty</h6>
                                <input type="password" class="form-control" v-model="seller.password" id="password"/>
                                <div class="error" v-if="seller.errors.has('password')" v-html="seller.errors.get('password')" />
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" v-model="seller.status" name="status" value="1">
                                            Active
                                            <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" v-model="seller.status" name="status" value="0">
                                            Deactive
                                            <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="error" v-if="seller.errors.has('status')" v-html="seller.errors.get('status')" />
                            </div>

                            <hr>
                            <div class="form-group" v-if="!editMood">
                                <label for="credit">Credit</label>
                                <input type="number" class="form-control" v-model="seller.credit" id="credit"/>
                                <div class="error" v-if="seller.errors.has('credit')" v-html="seller.errors.get('credit')" />
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" v-if="editMood" @click="update">Update</button>
                        <button type="submit" class="btn btn-primary" v-else @click="store">Save</button>
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
            sellers: {},

            seller: new Form({
                id: '',
                name: '',
                email: '',
                password: '',
                status: '',
                credit: '',
            }),

            editMood: false,
        }
    },
    methods: {

        async destroy(id){
            
            Confirm.show(
                'Confirm',
                'Do you want to delete this?',
                'Yes',
                'No',
                () => {
                    Block.dots('#page-content');
                    axios.delete('/api/supadm/seller/delete/'+id)
                    .then(res=>{
                        Notify.success('Delete successful');
                        this.get(this.sellers.current_page)
                        Block.remove('#page-content');
                    })
                    .catch(e=>{
                        console.log(e);
                        Block.remove('#page-content');
                    })
                },
            );
        },

        async update(){
            Block.dots('#page-content');
            await this.seller.put('/api/supadm/seller/update')
            .then(res=>{
                Notify.success('Update successful');
                this.seller.clear();
                this.seller.reset();
                this.get(this.sellers.current_page)
                Block.remove('#page-content');
            })
            .catch(e=>{
                console.log(e);
                Block.remove('#page-content');
            })
        },

        showUpdateForm(data){
            this.editMood = true;
            this.seller.reset();
            this.seller.clear();
            this.seller.fill(data);
            $("#defaultModal").modal({backdrop: 'static', keyboard: false});
        },

        async store(){
            Block.dots('#page-content');
            await this.seller.post('/api/supadm/seller/store')
            .then(res=>{
                Notify.success('Create successful');
                this.get();
                this.seller.clear();
                this.seller.reset();
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

        async get(page){
            Block.dots('#page-content');
            await axios.get('/api/supadm/seller/index?page='+page)
            .then(res=>{
                this.sellers = res.data;
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