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
                <div class="col-md-8 col-sm-12">

                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">জমি</h3>
                            <p class="card-description">
                                সকল জমি
                            </p>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 12px;">#</th>
                                            <th>জমির নাম</th>
                                            <th>পরিমান</th>
                                            <th>পাম্প অপারেটর</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(land, index) in lands.data" :key="index" @click="landDetails(land.id)" role="button">
                                            <td>{{index+1}}</td>
                                            <td>{{land.name}}</td>
                                            <td>{{land.land_area}}</td>
                                            <td>{{land.operator.name_title}} {{land.operator.f_name}} {{land.operator.l_name}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <pagination class="mb-0" :limit=3 :data="lands" @pagination-change-page="get"></pagination>
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

        }
    },
    methods: {

    },
    mounted(){

    }
}
</script>
<style scoped>
    .content{
        margin: -25px 0 0 -31px;
    }
</style>