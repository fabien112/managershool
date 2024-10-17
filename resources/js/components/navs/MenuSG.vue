<template>
    <div>
        <aside class="main-sidebar">
            <!-- sidebar-->
            <section class="sidebar position-relative">
                <div class="multinav">
                    <div class="multinav-scroll" style="height: 100%; background-color: #2C353D; ">
                        <!-- sidebar menu-->
                        <ul class="sidebar-menu" data-widget="tree" style="height: 100%; background-color: #2C353D; ">
                            <!--  Menu local dashboard -->
                            <li class="treeview">
                                <router-link to="dashboardsg">
                                    <!-- <i class="icon-Layout-4-blocks"><span class="path1"></span><span
                                            class="path2"></span></i> -->


                                            <span style="font-size:20px"> 💻  </span>
                                    <span> Dashboard </span>
                                </router-link>
                            </li>



                            <li class="treeview">
                                <router-link to="absenceSelect">
                                    <!-- <i class="icon-Layout-4-blocks"><span class="path1"></span><span
                                            class="path2"></span></i> -->


                                            <span style="font-size:20px"> 📚 </span>
                                    <span> Gestion des absences </span>
                                </router-link>
                            </li>




                            <li class="treeview">
                                <router-link to="cycleSg">
                                    <!-- <i class="icon-Layout-4-blocks"><span class="path1"></span><span class="path2"></span></i> -->


                                    <span style="font-size:20px"> 📒 </span>
                                    <span> Gestion de la discipline    </span>

                                </router-link>
                            </li>

                             <li class="treeview">
                                <router-link to="messagerieSG">
                                    <!-- <i class="icon-Notifications"><span class="path1"></span><span
                                            class="path2"></span></i> -->

                                            <span style="font-size:20px"> ✉️ </span>
                                    <span> Messages </span>
                                </router-link>
                            </li>

                            <!-- <li class="treeview">
                                <router-link to="coursDashLocal">
                                    <i class="icon-Notifications"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span> Cours en ligne </span>

                                </router-link>
                            </li> -->



                            <!-- <li class="treeview">
                                <router-link to="importations">
                                    <i class="icon-Layout-4-blocks"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span> Importations </span>
                                </router-link>
                            </li> -->

                        </ul>
                    </div>
                </div>
            </section>
            <div class="sidebar-footer" style="background-color: #2C353D;">
                <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Settings"
                    aria-describedby="tooltip92529"><span class="icon-Settings-2"></span></a>
                <a href="mailbox.html" class="link" data-toggle="tooltip" title="" data-original-title="Email"><span
                        class="icon-Mail"></span></a>
                <a href="javascript:void(0)" class="link" data-toggle="tooltip" title=""
                    data-original-title="Logout"><span class="icon-Lock-overturning"><span class="path1"></span><span
                            class="path2"></span></span></a>
            </div>
        </aside>

        <div class="control-sidebar-bg"></div>
    </div>
</template>

<script>
export default {

    mounted() {
        // console.log('Component mounted.')
    },

    data() {
        return {

            isActive: true,
            hasError: false
        }


    },

    methods: {

        color() {

            this.isActive = red
        }
    }

}
</script>

<style scoped>
.sidebar-menu {
    white-space: nowrap;
    overflow: hidden;
    background-color: white;
}

.router-link-exact-active {
    background: #18222A
}

span {
    color: #6B7886
}
</style>
