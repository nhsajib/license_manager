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
                    <form @submit.prevent="updateInfo">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Software Information</h3>
                            </div>

                            <div class="card-body">

                                <div class="form-group">
                                    <label for="version">Version</label>
                                    <input type="text" class="form-control" v-model="softinfo.version">
                                    <div class="error" v-if="softinfo.errors.has('version')" v-html="softinfo.errors.get('version')" />
                                </div>
                                <div class="form-group">
                                    <label for="lastupdate">Last Update</label>
                                    <input type="date" class="form-control" v-model="softinfo.lastupdate">
                                    <div class="error" v-if="softinfo.errors.has('lastupdate')" v-html="softinfo.errors.get('lastupdate')" />
                                </div>
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" v-model="softinfo.title">
                                    <div class="error" v-if="softinfo.errors.has('title')" v-html="softinfo.errors.get('title')" />
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea v-model="softinfo.message" class="form-control" cols="30" rows="10"></textarea>
                                    <div class="error" v-if="softinfo.errors.has('message')" v-html="softinfo.errors.get('message')" />
                                </div>
                                <div class="form-group">
                                    <label for="updatelink">Update Link</label>
                                    <input type="text" class="form-control" v-model="softinfo.updatelink">
                                    <div class="error" v-if="softinfo.errors.has('updatelink')" v-html="softinfo.errors.get('updatelink')" />
                                </div>
                                <div class="form-group">
                                    <label for="serverlink">Server Link</label>
                                    <input type="text" class="form-control" v-model="softinfo.serverlink">
                                    <div class="error" v-if="softinfo.errors.has('serverlink')" v-html="softinfo.errors.get('serverlink')" />
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary btn-block">Save</button>
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

            softinfo: new Form({
                id: '',
                version: '',
                lastupdate: '',
                title: '',
                message: '',
                updatelink: '',
                serverlink: '',
            }),
        
        }
    },
    methods: {

        async updateInfo(){
            Block.dots('#page-content');
            await this.softinfo.put('/api/supadm/software/info/update')
            .then(res=>{
                Notify.success('Update successful');
                Block.remove('#page-content');
            })
            .catch(e=>{
                console.log(e);
                Block.remove('#page-content');
            })
        },

        async get(){
            Block.dots('#page-content');
            await axios.get('/api/supadm/software/info/get')
            .then(res=>{
                this.softinfo.fill(res.data);
                Block.remove('#page-content');
            })
            .catch(e=>{
                console.log(e);
                Block.remove('#page-content');
            })
        },
    
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