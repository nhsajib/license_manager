<template>
    <div class="content-wrapper d-flex align-items-center text-center error-page bg-primary" id="page-404">
        <div class="row flex-grow">
            <div class="col-lg-7 mx-auto text-white">
            <div class="row align-items-center d-flex flex-row">
                <div class="col-lg-6 text-lg-right pr-lg-4">
                <h1 class="display-1 mb-0">404</h1>
                </div>
                <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                <h2>SORRY!</h2>
                <h3 class="font-weight-light">The page you’re looking for was not found.</h3>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 text-center mt-xl-2">
                <router-link class="text-white font-weight-medium" to="/">Back to home</router-link>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    #page-404{
        position: fixed;
        z-index: 2500;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
    }
</style>