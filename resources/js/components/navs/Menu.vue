<template>
    <div>
        <aside class="main-sidebar">
            <!-- sidebar-->
            <section class="sidebar position-relative">
                <div class="multinav">
                    <div class="multinav-scroll" style="height: 100%;">
                        <!-- sidebar menu-->
                        <ul class="sidebar-menu" data-widget="tree">
                            <!-- <li class="header">Dashboard & Apps</li> -->
                            <li class="treeview">
                                <router-link to="dashboard">
                                    <i class="icon-Layout-4-blocks"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                    ></i>
                                    <span>Dashboard</span>
                                </router-link>
                            </li>
                            <li class="treeview">
                                <router-link to="etablissementDash">
                                    <i span class="icon-Layout-grid"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                    ></i>
                                    <span>Etablissements</span>
                                </router-link>
                                <!-- <ul class="treeview-menu">
                                    <li>
                                        <router-link to="addetablissement"
                                            ><i class="icon-Commit"
                                                ><span class="path1"></span
                                                ><span class="path2"></span></i
                                            >Nouveau</router-link
                                        >
                                    </li>
                                    <li>
                                        <router-link to="etablissements"
                                            ><i class="icon-Commit"
                                                ><span class="path1"></span
                                                ><span class="path2"></span></i
                                            >Liste</router-link
                                        >
                                    </li>
                                    <li>
                                        <a href="contact_app_chat.html"
                                            ><i class="icon-Commit"
                                                ><span class="path1"></span
                                                ><span class="path2"></span></i
                                            >Chat</a
                                        >
                                    </li>
                                    <li>
                                        <a href="extra_taskboard.html"
                                            ><i class="icon-Commit"
                                                ><span class="path1"></span
                                                ><span class="path2"></span></i
                                            >Todo</a
                                        >
                                    </li>
                                    <li>
                                        <a href="mailbox.html"
                                            ><i class="icon-Commit"
                                                ><span class="path1"></span
                                                ><span class="path2"></span></i
                                            >Mailbox</a
                                        >
                                    </li>
                                </ul> -->
                            </li>
                            <!-- <li class="header">Components & UI </li> -->
                            <li class="treeview">
                                <a href="#">
                                    <i class="icon-Write"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                    ></i>
                                    <span>Elèves</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="icon-File"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                        ><span class="path3"></span
                                    ></i>
                                    <span>Absences</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="icon-Chart-pie"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                    ></i>
                                    <span>Evaluations et notes</span>
                                </a>
                            </li>
                            <!-- <li class="header">COLLECTIONS</li> -->
                            <li class="treeview">
                                <a href="#">
                                    <i class="icon-Library"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                    ></i>
                                    <span>Emplois du temps</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="icon-Cart"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                    ></i>
                                    <span>Souscriptions</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="icon-Mail"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                    ></i>
                                    <span>Messages</span>
                                </a>
                            </li>
                            <!-- <li class="header">LOGIN & ERROR </li> -->
                            <li class="treeview">
                                <a href="#">
                                    <i class="icon-Chat-locked"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                    ></i>
                                    <span>Utilisateurs</span>
                                </a>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="icon-Chat-check"
                                        ><span class="path1"></span
                                        ><span class="path2"></span
                                    ></i>
                                    <span>Miscellaneous</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <div class="sidebar-footer">
                <a
                    href="javascript:void(0)"
                    class="link"
                    data-toggle="tooltip"
                    title=""
                    data-original-title="Settings"
                    aria-describedby="tooltip92529"
                    ><span class="icon-Settings-2"></span
                ></a>
                <a
                    href="mailbox.html"
                    class="link"
                    data-toggle="tooltip"
                    title=""
                    data-original-title="Email"
                    ><span class="icon-Mail"></span
                ></a>
                <a
                    href="javascript:void(0)"
                    class="link"
                    data-toggle="tooltip"
                    title=""
                    data-original-title="Logout"
                    ><span class="icon-Lock-overturning"
                        ><span class="path1"></span
                        ><span class="path2"></span></span
                ></a>
            </div>
        </aside>
        <aside class="control-sidebar">
            <div class="rpanel-title">
                <span class="pull-right btn btn-circle btn-danger"
                    ><i
                        class="ion ion-close text-white"
                        data-toggle="control-sidebar"
                    ></i
                ></span>
            </div>
            <!-- Create the tabs -->
            <ul class="nav nav-tabs control-sidebar-tabs">
                <li class="nav-item">
                    <a
                        href="#control-sidebar-home-tab"
                        data-toggle="tab"
                        class="active"
                        ><i class="mdi mdi-message-text"></i
                    ></a>
                </li>
                <li class="nav-item">
                    <a href="#control-sidebar-settings-tab" data-toggle="tab"
                        ><i class="mdi mdi-playlist-check"></i
                    ></a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Home tab content -->
                <div class="tab-pane active" id="control-sidebar-home-tab">
                    <div class="flexbox">
                        <a href="javascript:void(0)" class="text-grey">
                            <i class="ti-more"></i>
                        </a>
                        <p>Users</p>
                        <a
                            href="javascript:void(0)"
                            class="text-right text-grey"
                            ><i class="ti-plus"></i
                        ></a>
                    </div>
                    <div
                        class="lookup lookup-sm lookup-right d-none d-lg-block"
                    >
                        <input
                            type="text"
                            name="s"
                            placeholder="Search"
                            class="w-p100"
                        />
                    </div>
                    <div class="media-list media-list-hover mt-20">
                        <div class="media py-10 px-0">
                            <a class="avatar avatar-lg status-success" href="#">
                                <img src="images/avatar/1.jpg" alt="..." />
                            </a>
                            <div class="media-body">
                                <p class="font-size-16">
                                    <a class="hover-primary" href="#"
                                        ><strong>Tyler</strong></a
                                    >
                                </p>
                                <p>Praesent tristique diam...</p>
                                <span>Just now</span>
                            </div>
                        </div>

                        <div class="media py-10 px-0">
                            <a class="avatar avatar-lg status-danger" href="#">
                                <img src="images/avatar/2.jpg" alt="..." />
                            </a>
                            <div class="media-body">
                                <p class="font-size-16">
                                    <a class="hover-primary" href="#"
                                        ><strong>Luke</strong></a
                                    >
                                </p>
                                <p>Cras tempor diam ...</p>
                                <span>33 min ago</span>
                            </div>
                        </div>

                        <div class="media py-10 px-0">
                            <a class="avatar avatar-lg status-warning" href="#">
                                <img src="images/avatar/3.jpg" alt="..." />
                            </a>
                            <div class="media-body">
                                <p class="font-size-16">
                                    <a class="hover-primary" href="#"
                                        ><strong>Evan</strong></a
                                    >
                                </p>
                                <p>In posuere tortor vel...</p>
                                <span>42 min ago</span>
                            </div>
                        </div>

                        <div class="media py-10 px-0">
                            <a class="avatar avatar-lg status-primary" href="#">
                                <img src="images/avatar/4.jpg" alt="..." />
                            </a>
                            <div class="media-body">
                                <p class="font-size-16">
                                    <a class="hover-primary" href="#"
                                        ><strong>Evan</strong></a
                                    >
                                </p>
                                <p>In posuere tortor vel...</p>
                                <span>42 min ago</span>
                            </div>
                        </div>

                        <div class="media py-10 px-0">
                            <a class="avatar avatar-lg status-success" href="#">
                                <img src="images/avatar/1.jpg" alt="..." />
                            </a>
                            <div class="media-body">
                                <p class="font-size-16">
                                    <a class="hover-primary" href="#"
                                        ><strong>Tyler</strong></a
                                    >
                                </p>
                                <p>Praesent tristique diam...</p>
                                <span>Just now</span>
                            </div>
                        </div>

                        <div class="media py-10 px-0">
                            <a class="avatar avatar-lg status-danger" href="#">
                                <img src="images/avatar/2.jpg" alt="..." />
                            </a>
                            <div class="media-body">
                                <p class="font-size-16">
                                    <a class="hover-primary" href="#"
                                        ><strong>Luke</strong></a
                                    >
                                </p>
                                <p>Cras tempor diam ...</p>
                                <span>33 min ago</span>
                            </div>
                        </div>

                        <div class="media py-10 px-0">
                            <a class="avatar avatar-lg status-warning" href="#">
                                <img src="images/avatar/3.jpg" alt="..." />
                            </a>
                            <div class="media-body">
                                <p class="font-size-16">
                                    <a class="hover-primary" href="#"
                                        ><strong>Evan</strong></a
                                    >
                                </p>
                                <p>In posuere tortor vel...</p>
                                <span>42 min ago</span>
                            </div>
                        </div>

                        <div class="media py-10 px-0">
                            <a class="avatar avatar-lg status-primary" href="#">
                                <img src="images/avatar/4.jpg" alt="..." />
                            </a>
                            <div class="media-body">
                                <p class="font-size-16">
                                    <a class="hover-primary" href="#"
                                        ><strong>Evan</strong></a
                                    >
                                </p>
                                <p>In posuere tortor vel...</p>
                                <span>42 min ago</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <!-- Settings tab content -->
                <div class="tab-pane" id="control-sidebar-settings-tab">
                    <div class="flexbox">
                        <a href="javascript:void(0)" class="text-grey">
                            <i class="ti-more"></i>
                        </a>
                        <p>Todo List</p>
                        <a
                            href="javascript:void(0)"
                            class="text-right text-grey"
                            ><i class="ti-plus"></i
                        ></a>
                    </div>
                    <ul class="todo-list mt-20">
                        <li class="py-15 px-5 by-1">
                            <!-- checkbox -->
                            <input
                                type="checkbox"
                                id="basic_checkbox_1"
                                class="filled-in"
                            />
                            <label
                                for="basic_checkbox_1"
                                class="mb-0 h-15"
                            ></label>
                            <!-- todo text -->
                            <span class="text-line">Nulla vitae purus</span>
                            <!-- Emphasis label -->
                            <small class="badge bg-danger"
                                ><i class="fa fa-clock-o"></i> 2 mins</small
                            >
                            <!-- General tools such as edit or delete-->
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li class="py-15 px-5">
                            <!-- checkbox -->
                            <input
                                type="checkbox"
                                id="basic_checkbox_2"
                                class="filled-in"
                            />
                            <label
                                for="basic_checkbox_2"
                                class="mb-0 h-15"
                            ></label>
                            <span class="text-line">Phasellus interdum</span>
                            <small class="badge bg-info"
                                ><i class="fa fa-clock-o"></i> 4 hours</small
                            >
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li class="py-15 px-5 by-1">
                            <!-- checkbox -->
                            <input
                                type="checkbox"
                                id="basic_checkbox_3"
                                class="filled-in"
                            />
                            <label
                                for="basic_checkbox_3"
                                class="mb-0 h-15"
                            ></label>
                            <span class="text-line">Quisque sodales</span>
                            <small class="badge bg-warning"
                                ><i class="fa fa-clock-o"></i> 1 day</small
                            >
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li class="py-15 px-5">
                            <!-- checkbox -->
                            <input
                                type="checkbox"
                                id="basic_checkbox_4"
                                class="filled-in"
                            />
                            <label
                                for="basic_checkbox_4"
                                class="mb-0 h-15"
                            ></label>
                            <span class="text-line">Proin nec mi porta</span>
                            <small class="badge bg-success"
                                ><i class="fa fa-clock-o"></i> 3 days</small
                            >
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li class="py-15 px-5 by-1">
                            <!-- checkbox -->
                            <input
                                type="checkbox"
                                id="basic_checkbox_5"
                                class="filled-in"
                            />
                            <label
                                for="basic_checkbox_5"
                                class="mb-0 h-15"
                            ></label>
                            <span class="text-line">Maecenas scelerisque</span>
                            <small class="badge bg-primary"
                                ><i class="fa fa-clock-o"></i> 1 week</small
                            >
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li class="py-15 px-5">
                            <!-- checkbox -->
                            <input
                                type="checkbox"
                                id="basic_checkbox_6"
                                class="filled-in"
                            />
                            <label
                                for="basic_checkbox_6"
                                class="mb-0 h-15"
                            ></label>
                            <span class="text-line">Vivamus nec orci</span>
                            <small class="badge bg-info"
                                ><i class="fa fa-clock-o"></i> 1 month</small
                            >
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li class="py-15 px-5 by-1">
                            <!-- checkbox -->
                            <input
                                type="checkbox"
                                id="basic_checkbox_7"
                                class="filled-in"
                            />
                            <label
                                for="basic_checkbox_7"
                                class="mb-0 h-15"
                            ></label>
                            <!-- todo text -->
                            <span class="text-line">Nulla vitae purus</span>
                            <!-- Emphasis label -->
                            <small class="badge bg-danger"
                                ><i class="fa fa-clock-o"></i> 2 mins</small
                            >
                            <!-- General tools such as edit or delete-->
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li class="py-15 px-5">
                            <!-- checkbox -->
                            <input
                                type="checkbox"
                                id="basic_checkbox_8"
                                class="filled-in"
                            />
                            <label
                                for="basic_checkbox_8"
                                class="mb-0 h-15"
                            ></label>
                            <span class="text-line">Phasellus interdum</span>
                            <small class="badge bg-info"
                                ><i class="fa fa-clock-o"></i> 4 hours</small
                            >
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li class="py-15 px-5 by-1">
                            <!-- checkbox -->
                            <input
                                type="checkbox"
                                id="basic_checkbox_9"
                                class="filled-in"
                            />
                            <label
                                for="basic_checkbox_9"
                                class="mb-0 h-15"
                            ></label>
                            <span class="text-line">Quisque sodales</span>
                            <small class="badge bg-warning"
                                ><i class="fa fa-clock-o"></i> 1 day</small
                            >
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                        <li class="py-15 px-5">
                            <!-- checkbox -->
                            <input
                                type="checkbox"
                                id="basic_checkbox_10"
                                class="filled-in"
                            />
                            <label
                                for="basic_checkbox_10"
                                class="mb-0 h-15"
                            ></label>
                            <span class="text-line">Proin nec mi porta</span>
                            <small class="badge bg-success"
                                ><i class="fa fa-clock-o"></i> 3 days</small
                            >
                            <div class="tools">
                                <i class="fa fa-edit"></i>
                                <i class="fa fa-trash-o"></i>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- /.tab-pane -->
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
</style>
