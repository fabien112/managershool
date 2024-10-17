<template>

  <div>
        <div class="wrapper">
            <Header />
            <MenuLocal />
            <div class="content-wrapper">
                <div class="container-full">

                    <section class="content">

		  <!-- tabs -->

		  <div class="row">

			<div class="col-12">
			  <div class="box box-default">
				<div class="box-header with-border">

				   <div class="row">


                        <div class="col md-6"> <span style="color:rgb(21, 69, 156)"> Destinataires :</span> <span style="font-weight: bold;"> {{MessageParentEnvoyes.type_destinataire}}</span> </div>

                        <div class="col md-6"> <span style="color:rgb(21, 69, 156)"> Date d'envoi :</span> <span style="font-weight: bold;"> {{MessageParentEnvoyes.messages.date}}</span> </div>


                    </div>

				</div>
				<!-- /.box-header -->
				<div class="box-body">

                    <div class="row">


                        <div class="col-md-12">

                            <h5 style="color:rgb(23, 64, 139)"> Objet : {{MessageParentEnvoyes.messages.object}} </h5> <br>


                             <h6 style="font-family: cursive"> {{MessageParentEnvoyes.messages.commentaires}} </h6><br><br><br><br><br>

                             <span style="color:rgb(21, 69, 156)"> Expediteur

                                 <br> </span>  <span style="font-weight: bold;"> Vous </span>
                             <br>

                        </div>


                    </div>

                    <div class="row" v-if="MessageParentEnvoyes.messages.document==null">

                        <Divider/>

                        <div class="col-md-10">

                            <p> <Icon type="ios-link" /> Pas de document  joint pour ce message  </p>

                        </div>
                    </div>

                      <div class="row" v-if="MessageParentEnvoyes.messages.document!=null">

                        <Divider/>

                        <div class="col-md-10">

                            <h5> <Icon type="ios-link" /> (1) document joint  </h5>

                            <div class="media media-single px-0">
                                <div class="ms-0 me-15 bg-primary h-50 w-50 l-h-50 rounded text-center">
                                        <span class="fs-24 text-success"><a download='document' :href="`/Photos/Logos/${MessageParentEnvoyes.messages.document}`"><Icon style="color:rgb(247, 249, 253)" type="md-document" /></a></span>
                                </div>

                          </div>


                        </div>
                    </div>


				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->
			</div>

		  </div>


		</section>

                </div>
            </div>
        </div>
        <Chats />
    </div>

</template>

<script>
import Header from "../../headers/Header.vue";
import MenuLocal from "../../navs/MenuLocal.vue";
import Chats from "../../navs/Chats.vue";
import { mapState } from "vuex";
import {
    required,
    minLength,
    alpha,
    email,
    maxLength,
    sameAs
} from "vuelidate/lib/validators";
import { log } from "util";

export default {
    components: { Header, MenuLocal, Chats },
    data() {
        return {
            data: {

                 users:''

            },

            MessageParent:[],
            MessageParentEnvoyes:[]

        }
    },


    methods: {

    } ,

    async mounted() {


            if (localStorage.messageSend) {

                this.MessageParentEnvoyes = JSON.parse(localStorage.getItem("messageSend"));

                }

        const response = await this.callApi(
            "post",
            "api/parent/updateMessagesParent",
            this.MessageParent
        );

        }

}
</script>

<style>

.content-wrapper{
    background-color: #FAFBFD
}
.demo-upload-list {
    display: inline-block;
    width: 60px;
    height: 60px;
    text-align: center;
    line-height: 60px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    margin-right: 4px;
}
.demo-upload-list img {
    width: 100%;
    height: 100%;
}
.demo-upload-list-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, 0.6);
}
.demo-upload-list:hover .demo-upload-list-cover {
    display: block;
}
.demo-upload-list-cover i {
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
}
</style>
