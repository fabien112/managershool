<template>
<div class="auth-wrapper">

    <router-view></router-view>
</div>

</template>

<script>
    export default {
        data()
        {
           return {
            IsloggedIn:false,

           }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
