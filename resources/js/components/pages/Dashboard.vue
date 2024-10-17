<template>

<div>
<div class="wrapper">
<Header/>
<Menu/>
<div class="content-wrapper">
<div class="container-full">

<section class="content">

<div class="row align-items-end">
				<div class="col-xl-12 col-12">
					<div class="box bg-primary-light pull-up">
						<div class="box-body p-xl-0">
							<div class="row align-items-center">
								<div class="col-12 col-lg-3"><img src="" alt=""></div>
								<div class="col-12 col-lg-9">
									<h2> Hello {{$store.state.userDatas.nom}}, Bienvenu!</h2>
									<p class="text-dark mb-0 font-size-16">
										Your course Overcoming the fear of public speaking was completed by 11 New users this week!
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

</section>


</div>

</div>
</div>
<Chats/>

</div>
</template>

<script>

import Header from '../headers/Header.vue';
import Menu from '../navs/Menu.vue';
import Chats from '../navs/Chats.vue';

    export default {


        components:{Header,Menu,Chats},
        data() {
      return {
          UserData : []
      }
    },

       async  mounted() {
            console.log('Component mounted.');
            if (localStorage.getItem('UserData'))

            {
                let thedata = JSON.parse(localStorage.getItem('UserData'));
                // console.log(thedata.data.data);
                this.UserData=thedata.data.data;
                // let data=JSON.parse(thedata);
                // console.log(data);
            }

        }


    }
</script>
