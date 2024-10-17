<template>
<div class="">

    <router-view>

        

    </router-view>

</div>

</template>

<script>
    export default {
        data()
        {
           return {
            IsloggedIn:false,
            pageLogin:true,

           }
        },

       
        created()
        {
           
        }
    }
</script>

<style>

        .fade-enter-active, .fade-leave-active {
        transition: opacity .5s,transform 1s;
        }
        .fade-enter, .fade-leave-to  {
        opacity: 0;
        transform: translate(20px)
        } 

</style>

