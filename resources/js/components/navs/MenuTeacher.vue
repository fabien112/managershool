<template>
    <div>
        <aside class="main-sidebar">
            <!-- sidebar-->
            <section class="sidebar position-relative">
                <div class="multinav">
                    <div class="multinav-scroll" style="height: 100%; background-color: #2C353D; ">
                        <!-- sidebar menu-->
                        <ul class="sidebar-menu" data-widget="tree" style="background-color: #2C353D;">
                            <!--  Menu local dashboard -->
                            <li class="treeview">
                                <router-link to="dashTeacher">
                                    <i class="icon-Layout-4-blocks"><span class="path1"></span><span
                                            class="path2"></span></i>
                                    <span> Dashboard </span>
                                </router-link>
                            </li>

                            <!-- Menu local session   -->

                            <li class="treeview">
                                <router-link to="enseignementTeacher">
                                    <i class="icon-Write"><span class="path1"></span><span class="path2"></span></i>
                                    <span> Enseignements </span>
                                </router-link>
                            </li>

                            <!-- Menu local administration   -->

                            <li class="treeview">
                                <router-link to="appelTeacher">
                                    <i class="icon-File"><span class="path1"></span><span class="path2"></span></i>
                                    <span> Présences </span>
                                </router-link>
                            </li>

                            <li class="treeview">
                                <router-link to="retard">
                                    <i class="icon-File"><span class="path1"></span><span class="path2"></span></i>
                                    <span> Retards  </span>
                                </router-link>
                            </li>

                            <!-- Menu gestion eleve   -->

                            <!-- <li class="treeview">
                                <router-link to="teacherclasse">
                                    <i class="icon-User"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                    ></i>
                                    <span> Classes </span>
                                </router-link>
                            </li> -->

                            <!-- Menu gestion des messsages  -->

                            <li class="treeview">
                                <router-link to="messageDashTeacher">
                                    <i class="icon-Write"><span class="path1"></span><span class="path2"></span></i>
                                    <span> Messages </span>
                                </router-link>
                            </li>


                            <!-- <li class="treeview">
                                <router-link to="quizz">
                                    <i class="icon-Cart"><span class="path1"></span><span class="path2"></span></i>
                                    <span> Quizz en ligne </span>

                                </router-link>
                            </li>

                            <li class="treeview">
                                <router-link to="cours">
                                    <i class="icon-Write"><span class="path1"></span><span class="path2"></span></i>
                                    <span> Cours en ligne </span>

                                </router-link>
                            </li>

                            -->

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
    }
};
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
