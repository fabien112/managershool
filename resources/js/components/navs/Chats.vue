<template>
    <div>
        <div id="chat-box-body">
            <div
                id="chat-circle"
                class="waves-effect waves-circle btn btn-circle btn-lg -light l-h-70"
            >
                <div id="chat-overlay"></div>
                <span class="font-size-30">
                    <img
                        src="/images/wp.gif"
                        alt=""
                        style="padding-bottom: 30px;"
                    />
                    <span class="path1"> </span>
                    <span class="path2"></span>
                </span>
            </div>

            <div class="chat-box">
                <div
                    class="chat-box-header p-15 d-flex justify-content-between align-items-center"
                    style="border-radius: 5px 10px 0 5px;
    background-color: #82d47e;"
                >
                    <div class="flex-grow-1">
                        <div class="text-dark font-size-18">
                            <span>
                                <Icon
                                    type="logo-whatsapp"
                                    style="color: #fafafa;font-size:40px"
                                />
                                Whatsapp</span
                            >
                            <div></div>
                        </div>
                    </div>
                    <div class="chat-box-toggle">
                        <button
                            id="chat-box-toggle"
                            class="waves-effect waves-circle btn btn-circle btn-danger-light h-40 w-40 rounded-circle l-h-45"
                            type="button"
                        >
                            <span class="icon-Close font-size-22"
                                ><span class="path1"></span
                                ><span class="path2"></span
                            ></span>
                        </button>
                    </div>
                </div>
                <div class="container">
                    <div class="chat-msg user">
                        <div class="d-flex align-items-center">
                            <span class="msg-avatar">
                                <img
                                    src="/images/avatar-15.png"
                                    class="avatar avatar-lg"
                                />
                            </span>
                            <div class="mx-10">
                                <a
                                    disabled=""
                                    class="text-dark hover-primary font-weight-bold"
                                >
                                    Assistance technique
                                </a>
                                <p class="text-muted font-size-12 mb-0">
                                    <span
                                        class="badge badge-sm badge-dot badge-success"
                                    ></span>
                                    <span class="text-muted font-size-12"
                                        >En ligne</span
                                    >
                                </p>
                            </div>
                        </div>
                        <div class="cm-msg-text">
                            Bonjour! <br />Comment pouvons-nous vous aider ?
                        </div>
                    </div>
                </div>
                <div class="chat-input">
                    <div class="container">
                        <form id="validewhatsapp">
                            <div class="input-group">
                                <input

                                    v-model="data.message"
                                    type="text"
                                    class="form-control"
                                    id="messagewhatsapp"
                                    name="messagewhatsapp"
                                    placeholder="Saisir le message"

                                />
                                <div class="input-group-append">
                                    <a
                                        class="btn"
                                        id="buttonsend"
                                        @click="sendwhatsapp"
                                        ><Icon type="ios-paper-plane"
                                    /></a>
                                </div>
                            </div>
                        </form>
                        <br />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        // console.log('Component mounted.')
    },

 data() {
        return {

            data: {

                message:''
            },
        }
    },

    methods: {
        sendwhatsapp() {
            if (this.data.message == "") {
            } else {
                var send =
                    "https://api.whatsapp.com/send?phone=+237699481386&text=" +
                    this.data.message;
                window.open(send);
                this.data.message = ''
            }
        }
    }
}
</script>

<style scoped></style>
