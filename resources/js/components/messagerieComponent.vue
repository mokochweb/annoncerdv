<template>
    <div class="container">
        <div class="messaging">
            <div class="inbox_msg">
                <div class="inbox_people">
                    <div class="headind_srch text-right">
                        <button v-if="groupe == false" class="btn btn-gold" type="button" v-on:click="groupes()">
                            Envoyer un message au groupe
                        </button>
                        <button v-else class="btn btn-danger" type="button" v-on:click="groupes()">
                            <i class="fa fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="inbox_chat">
                        <div v-for="annonce in posts" class="chat_list active_chat">
                            <a v-on:click="getPost(annonce.post_id)">

                                <div class="chat_people">
                                    <div class="chat_img"><img :src="currentRoute + annonce.post.user.avatar"
                                                               alt="avatar"></div>
                                    <div v-if="groupe == true" class="custom-control custom-checkbox text-right">
                                        <input class=" form-check-input custom-control-input" name="ids"
                                               type="checkbox"
                                               :id=" annonce.id "
                                               :value="annonce"
                                               v-model="sendGroup.checkboxListId">
                                        <label class="custom-control-label" :for=" annonce.id"></label>
                                    </div>
                                    <div class="chat_ib">
                                        <div>
                                            <strong>Titre: <span
                                                style="font-weight: 400;">{{ annonce.post.titre }}</span></strong>
                                        </div>
                                        <div>
                                            <strong>Quantité: <span style="font-weight: 400;">Entre {{ annonce.post.qte }} Et {{ annonce.post.quantite2}} </span></strong>
                                        </div>
                                        <div>
                                            <strong>Date du rdv: <span style="font-weight: 400;">{{ annonce.post.daterdvbegin }}  à {{ annonce.post.daterdvend}} </span></strong>
                                        </div>
                                        <div>
                                            <strong>Heure du rdv: <span style="font-weight: 400;">{{ annonce.post.Hbeginrdv }}  à {{ annonce.post.Hendrdv}} </span></strong>
                                        </div>
                                        <div>
                                            <strong>Adresse: <span
                                                style="font-weight: 400;">{{ annonce.post.adresse }}</span></strong>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mesgs">
                    <div class="headind_srch">
                        <div v-if="infotosend.toUserPseudo != null && groupe == false">
                            <h4>Envoyer un message à {{ infotosend.toUserPseudo }}</h4>
                            <div class="text-right" v-if="delet == false">
                                <button type="button" v-on:click="deleteOpen()" class="btn btn-danger"><i
                                    class="fa fa-trash"></i></button>
                            </div>
                            <div class="text-right" v-else>
                                <button type="button" v-on:click="deleteOpen()" class="btn btn-gold"><i
                                    class="fa fa-times-circle"></i></button>
                                <button type="button" v-on:click="deleteMessage(infotosend.postId)" class="btn btn-danger"><i
                                    class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <div v-if="infotosend.toUserPseudo != null && groupe == true">
                            <h4>Envoyer un message à <span style="font-size: 18px" class="px-1"
                                                           v-for="(name,key) in sendGroup.checkboxListId">
                                <span v-if="name.from_user_id == userid">{{ name.to_user.pseudo }}</span>
                                <span v-if="name.to_user_id == userid">{{ name.from_user.pseudo }}</span>
                                <span v-if="key + 1 < sendGroup.checkboxListId.length">,</span>
                            </span></h4>
                        </div>
                        <div class="text-center" v-if="infotosend.toUserPseudo == null && groupe == false">
                            Aucun message sélectionné
                        </div>
                        <div v-if="groupe == true" class="alert alert-warning" role="alert">
                            <h5 style="color: #000">Attention</h5>
                            <p>
                                Méfiez-vous des propositions trop alléchantes et des prix trop bas,
                                Assurez-vous de ne pas être victime d'une tentative d'escroquerie.
                                <br>
                                <a href="">En savoir plus</a>
                            </p>
                        </div>
                    </div>
                    <div class="msg_history">
                        <div>
                            <div v-if="groupe == false" v-for="info in postInfo" class="incoming_msg">
                                <div v-if="userid == info.to_user_id ">
                                    <div class="incoming_msg_img">
                                        <img :src="currentRoute + info.post.user.avatar">
                                    </div>
                                    <div class="received_msg">
                                        <div class="received_withd_msg">
                                            <p>
                                                {{ info.message}}
                                            </p>
                                            <span class="time_date"> {{ info.time_created_at}} | {{ info.date_created_at}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="outgoing_msg">
                                    <div class="sent_msg">

                                        <p>
                                             <span>
                                                <div class="custom-control custom-checkbox text-left">
                                                    <input v-if="delet == true" class=" form-check-input custom-control-input" name="checkid"
                                                           type="checkbox"
                                                           :id=" info.id "
                                                           :value="info.id"
                                                           v-model="deleteIdList">
                                                    <label v-if="delet == true" class="custom-control-label" :for=" info.id"></label>
                                                    {{ info.message }}
                                                </div>
                                            </span>

                                        </p>
                                        <span
                                            class="time_date"> {{ info.time_created_at}} | {{ info.date_created_at}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="groupe == false && infotosend.toUserPseudo != null" class="type_msg">
                        <div class="input_msg_write py-1">
                            <input style="border:  1px solid" type="text" class="write_msg px-2" name="message"
                                   v-model="infotosend.message" placeholder="Écrivez un message.."/>
                        </div>
                        <button style="background-color: #eaedf1" v-on:click="send()" class="btn btn-light"
                                type="button">
                            <span class="px-2">Envoyer Votre Message</span>
                        </button>
                    </div>
                    <div v-else-if="groupe == true" class="type_msg">
                        <div class="input_msg_write py-1">
                            <input style="border:  1px solid" type="text" class="write_msg px-2" name="message"
                                   v-model="sendGroup.message" placeholder="Écrivez un message.."/>
                        </div>
                        <button style="background-color: #eaedf1" v-on:click="sendGroups()" class="btn btn-light"
                                type="button">
                            <span class="px-2">Envoyer Votre Message</span>
                        </button>
                    </div>
                    <div v-if="infotosend.toUserPseudo != null || groupe == true " class="form-group pt-4 pb-1">
                        <div style="height:120px;overflow:auto;color: #3490dc">
                            <a href="" data-toggle="modal" data-target="#collecte"> Me Renseigner sur le responsable de traitement, les destinataires et la finalité de la
                                collecte des données. <br></a>
                            <a href="" data-toggle="modal" data-target="#collecte">
                                Me Renseigner sur mes droits. la durée de conservation de mes données et les moyens de nous
                                contacter
                            </a>


                            <!-- Modal -->
                            <div class="modal fade" id="collecte" tabindex="-1" role="dialog" aria-labelledby="collecteLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                           <h5 class="text-center pt-5 pb-1" style="color: #000"> En savoir plus sur vos droits, la durée de conservation de vos données et les moyens de nous contacter</h5>
                                            <hr style="border-top: 1px solid rgb(255, 142, 25);">
                                            <div style="color: black">
                                                Pour en savoire plus :
                                                <ul>
                                                    <li>sur la durée de conservation de vos données, <a href="">Cliquez ici.</a></li>
                                                    <li>sur la durée de conservation de vos données, <a href="">Cliquez ici.</a></li>
                                                    <li>sur la durée de conservation de vos données, <a href="">Cliquez ici.</a></li>
                                                    <li>sur la durée de conservation de vos données, <a href="">Cliquez ici.</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                currentRoute: window.Laravel.url,
                posts: this.datas,
                userid: this.user,
                postInfo: null,
                delet: false,
                deleteIdList: [],
                infotosend: {
                    toUserId: null,
                    postId: null,
                    message: null
                },
                sendGroup: {
                    checkboxListId: [],
                    message: null
                },
                userListName: [],
                groupe: false,
            }
        },
        props: [
            'datas',
            'user'
        ],
        mounted: function () {
            window.setInterval(() => {
                this.getData()
            }, 2000)
        },
        methods: {
            getData(){
                axios.get('message/get/data')
                    .then((response) => {
                        this.posts = response.data
                    })
            },
            getPost(id) {
                axios.get('message/post/info/' + id)
                    .then((response) => {
                        this.postInfo = response.data
                        this.infotosend.toUserId = response.data[0].from_user_id
                        if (this.groupe == true) {
                            this.userListName = response.data[0].to_user.pseudo
                        }
                        if (response.data[0].from_user_id == this.userid) {
                            this.infotosend.toUserPseudo = response.data[0].to_user.pseudo
                        } else {
                            this.infotosend.toUserPseudo = response.data[0].from_user.pseudo
                        }
                        this.infotosend.postId = response.data[0].post_id
                        this.infotosend.message = null
                    })

            },
            sendGroups() {
                axios.post('message/post/group', this.sendGroup)
                    .then((response) => {
                        this.groupe = false
                        this.sendGroup.message = null
                        this.sendGroup.userListName = []
                    })
            },
            send() {
                axios.post('message/send', this.infotosend)
                    .then((response) => {
                        this.infotosend.message = null
                        this.getPost(this.infotosend.postId)
                    })
            },
            groupes() {
                if (this.groupe) {
                    this.groupe = false
                } else {
                    this.groupe = true
                }
            },
            deleteOpen() {
                if (this.delet) {
                    this.delet = false
                    this.deleteIdList = ['']
                } else {
                    this.delet = true
                }
            },
            deleteMessage(idPost){
                axios.post('message/delete/list', { 'id': this.deleteIdList })
                    .then((response) => {
                        this.deleteIdList = ['']
                        this.delet = false,
                            this.getPost(idPost);
                    })
            }

        }
    }
</script>
