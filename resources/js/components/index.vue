<template>

  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav-bar/>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">

      <!-- partial:partials/_sidebar.html -->
       <sidebar/>
      <!-- partial -->
      <div class="main-panel">
        <router-view></router-view>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footerx/>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

</template>

<script>
export default {
  methods: {

    async get(){
        await axios.get('/api/software/information')
        .then(res=>{
            this.$store.commit('setSoftwareInfo', res.data);
        })
        .catch(e=>{
            console.log(e);
        })
    },
    
  },
  mounted(){
    this.get();
  }
}
</script>

<style>
.modal-content {
    border-top: 2px solid #4B49AC;
}
.card-header h1, h2, h3, h4, h5, h6 {
    padding-bottom: 7px;
    /* padding: 0.675rem; */
}
.card-header .search-input{
    min-width: 250px;
}
.card{
  border-radius: 4px;
}
.card-header h1, h2, h3, h4 {
  margin-bottom: 0!important;
}
.card-header {
    padding: 1rem 1rem;
    background: #4b49ac17;
}
.form-group label {
  text-transform: capitalize;
}
.form-control, .asColorPicker-input, .dataTables_wrapper select, .jsgrid .jsgrid-table .jsgrid-filter-row input[type=text], .jsgrid .jsgrid-table .jsgrid-filter-row select, .jsgrid .jsgrid-table .jsgrid-filter-row input[type=number], .select2-container--default .select2-selection--single, .select2-container--default .select2-selection--single .select2-search__field, .typeahead, .tt-query, .tt-hint{
  height: 2.5rem;
  padding: 0.5rem 0.5rem;
}
.btn, .fc button, .ajax-upload-dragdrop .ajax-file-upload, .swal2-modal .swal2-buttonswrapper .swal2-styled, .swal2-modal .swal2-buttonswrapper .swal2-styled.swal2-confirm, .swal2-modal .swal2-buttonswrapper .swal2-styled.swal2-cancel, .wizard > .actions a{
  border-radius: 4px;
}
.modal .modal-dialog .modal-content .modal-footer {
  padding: 5px 20px;
}
.form-group .error{
  color: #f96868;
}
.input-group-append .input-group-text, .input-group-prepend .input-group-text{
  padding: 0.775rem 0.75rem;
}
.form-group label {
  font-weight: 500;
  font-size: 1rem;
}
.deep-green{
    color: #109618;
}
.v-center{
    display: table;
    width: 100%;
}
.v-center p {
    display: table-cell;
    vertical-align: middle;
    line-height: inherit;
    font-size: 2.5rem;
    padding-bottom: 2rem;
    text-align: center;
}
.all-center{
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
}

a:hover{
  text-decoration: none;
}

div.chart_div table {
  width: auto;
  margin: 0 auto !important;
}

/* Pump Details end MQ*/
.logout{
  border: 1px solid #4B49AC;
  padding: 5px 15px!important;
  border-radius: 5px;
  color: #4B49AC;
}
.logout:focus{
  border: 1px solid #4B49AC;
  color: #4B49AC;
}
.logout a span{
  color: #4B49AC!important;
}
.card{
  border-top: 1px solid #4B49AC;
}
.card-title{
  padding-bottom: 0px;
}
.v-center{
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}
</style>