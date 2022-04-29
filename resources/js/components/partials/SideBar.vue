<template>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">

        <!-- For Super Admin -->
        <ul class="nav" v-if="$store.state.user.type == 1">
            <li class="nav-item">
                <router-link class="nav-link" to="/">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/supadm/supper/sellers">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Supper Sellers</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/supadm/sellers">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Sellers</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/license">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">License</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/transfer/credit">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Transfer Credit</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/software/info">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Software Info</span>
                </router-link>
            </li>
        </ul>

        <!-- For Super Seller -->
        <ul class="nav" v-if="$store.state.user.type == 2">
            <li class="nav-item">
                <router-link class="nav-link" to="/">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/supsell/sellers">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Sellers</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/license">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">License</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/transfer/credit">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">Transfer Credit</span>
                </router-link>
            </li>

        </ul>

        <!-- For Super Seller -->
        <ul class="nav" v-if="$store.state.user.type == 3">
            <li class="nav-item">
                <router-link class="nav-link" to="/license">
                    <i class="icon-grid menu-icon"></i>
                    <span class="menu-title">License</span>
                </router-link>
            </li>
        </ul>

    </nav>
</template>
<script>
export default {
    data(){
        return{
            user: {},
        }
    },

    mounted(){
        this.user = this.$store.getters['loggedInUser'];
    }
}
</script>
<style scoped>
.router-link-exact-active{
    background: #4B49AC;
    color: #fff!important;
}
.router-link-exact-active i{
    color: #fff!important;
}
</style>