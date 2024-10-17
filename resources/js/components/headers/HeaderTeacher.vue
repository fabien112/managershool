<template>
    <header class="main-header">
        <div class="d-flex align-items-center logo-box justify-content-start" style="background-color: #18222A;">
            <a href="#" class="waves-effect waves-light nav-link d-none d-md-inline-block mx-10 push-btn bg-transparent"
                data-toggle="push-menu" role="button">
                <span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span
                        class="path3"></span></span>
            </a>
            <!-- Logo -->
            <a href="#" class="logo">
                <!-- logo-->
                <div class="logo-lg">
                    <span class="light-logo" style="color: white;"> <span
                            style="color: rgb(255, 208, 0);">X</span>schoolink</span>
                    <span class="dark-logo"><img src="assets/images/logo-dark.svg" alt="logo"></span>

                    <!-- <span class="light-logo"><img src="assets/images/logo-dark.PNG" alt="logo"></span>
			  <span class="dark-logo"><img src="assets/images/logo-dark.PNG" alt="logo"></span> -->

                </div>
            </a>
        </div>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <div class="app-menu">
                <!-- <ul class="header-megamenu nav">
			<li class="btn-group nav-item d-md-none">
				<a href="#" class="waves-effect waves-light nav-link push-btn" data-toggle="push-menu" role="button">
					<span class="icon-Align-left"><span class="path1"></span><span class="path2"></span><span class="path3"></span></span>
			    </a>
			</li>
			<li class="btn-group nav-item d-none d-xl-inline-block">
				<a href="#" class="waves-effect waves-light nav-link svg-bt-icon" title="Chat">
					<i class="icon-Chat"><span class="path1"></span><span class="path2"></span></i>
			    </a>
			</li>
			<li class="btn-group nav-item d-none d-xl-inline-block">
				<a href="#" class="waves-effect waves-light nav-link svg-bt-icon" title="Mailbox">
					<i class="icon-Mailbox"><span class="path1"></span><span class="path2"></span></i>
			    </a>
			</li>
			<li class="btn-group nav-item d-none d-xl-inline-block">
				<a href="#" class="waves-effect waves-light nav-link svg-bt-icon" title="Taskboard">
					<i class="icon-Clipboard-check"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
			    </a>
			</li>
		</ul> -->
            </div>

            <div class="navbar-custom-menu r-side">
                <ul class="nav navbar-nav">
                    <!-- <li class="btn-group nav-item d-lg-inline-flex d-none">
				<a href="#" data-provide="fullscreen" class="waves-effect waves-light nav-link full-screen" title="Full Screen">
					<i class="icon-Expand-arrows"><span class="path1"></span><span class="path2"></span></i>
			    </a>
			</li> -->
                    <!-- <li class="btn-group d-lg-inline-flex d-none">
				<div class="app-menu">
					<div class="search-bx mx-5">
						<form>
							<div class="input-group">
							  <input type="search" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="button-addon2">
							  <div class="input-group-append">
								<button class="btn" type="submit" id="button-addon3"><i class="ti-search"></i></button>
							  </div>
							</div>
						</form>
					</div>
				</div>
			</li> -->

                    <!-- Notifications -->
                    <!-- <li class="dropdown notifications-menu">
                        <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown"
                            title="Notifications">
                            <i class="icon-Menu"><span class="path1"></span><span class="path2"></span></i>
                        </a>
                        <ul class="dropdown-menu animated bounceIn">

                            <li class="header">
                                <div class="p-20">
                                    <div class="flexbox">

                                        <router-link to="dashTeacher">

                                            <div>
                                                <h4 class="mb-0 mt-0">Dashboard</h4>
                                            </div>

                                        </router-link>


                                    </div>
                                </div>
                            </li>

                            <li>

                                <ul class="menu sm-scrol">
                                    <li>


                                        <router-link to="enseignementTeacher">

                                            <Icon type="md-albums" /> Enseignements
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="absenceDashTeacher">

                                            <Icon type="ios-people" /> Absences
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="messageDashTeacher">

                                            <Icon type="md-chatboxes" /> Messages
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="quizz">

                                            <Icon type="ios-book" /> Quizz en ligne
                                        </router-link>
                                    </li>
                                    <li>
                                        <router-link to="cours">

                                            <Icon type="ios-bookmarks" /> Cours en ligne
                                        </router-link>

                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li> -->

                    <!-- User Account-->
                    <li class="dropdown user user-menu">
                        <a href="#" class="waves-effect waves-light dropdown-toggle" data-toggle="dropdown"
                            title="User">
                            <i class="icon-User"><span class="path1"></span><span class="path2"></span></i>
                        </a>
                        <ul class="dropdown-menu animated flipInX">
                            <li class="user-body" @click="Logout">
                                <!-- <a class="dropdown-item" href="#"><i class="ti-user text-muted mr-2"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="ti-wallet text-muted mr-2"></i> My
                                    Wallet</a>
                                <a class="dropdown-item" href="#"><i class="ti-settings text-muted mr-2"></i>
                                    Settings</a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i class="ti-lock text-muted mr-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Control Sidebar Toggle Button -->
                    <li>
                        <a href="#" title="Synchroniser" @click="Actualiser">
                            <Icon type="md-refresh-circle" />
                        </a>
                    </li>

                </ul>
            </div>
        </nav>
    </header>
</template>

<script>

export default {

    mounted() {
        // console.log('Component mounted.')
    },

    methods: {

        Actualiser() {
            this.$router.go();
        },
        Logout() {

            this.$router.push('login');
            localStorage.clear();

        }
    }
}
</script>




