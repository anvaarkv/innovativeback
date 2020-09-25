<template>
    <div id="postsrec">

        <div class="row justify-content-center">
            <div v-bind:class="{ succmsg: succmsg }">
                <div class="col-md-12 col-lg-12">
                    <div class="alert alert-success cusmsg">{{ actionmsg }}</div>
                </div>
            </div>
            <div class="col-md-12">
                <!-- Button trigger modal -->

                <!-- Modal -->

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-bind:class="{ showmodal:showmodal }">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Film Modal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method = "post" name="addFilm" id="addFilm" action="#" @submit.prevent="updateFilm">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="name" v-model="film.name" />
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" id="description" class="form-control" placeholder="description" v-model="film.description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="release_date">Release Date</label>
                                        <input type="date" name="release_date" id="release_date" class="form-control" placeholder="release date" v-model="film.release_date"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="ticket_price">Ticket Price</label>
                                        <input type="text" name="ticket_price" id="ticket_price" class="form-control" placeholder="ticket price" v-model="film.ticket_price"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="rating">Rating</label>
                                        <select class="form-control" name="rating" id="rating" v-model="film.rating">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="form-group text-right">
                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <p>Are you sure want to delete the record? </p>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-success" v-on:click="hideModal()">Cancel</button>
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-success" v-on:click="deleteFilm()">Ok</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Films List</div>
                    <div class="card-body">
                        <table class="table table-striped" v-bind:pagenumber = "pagenumber">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Photo</th>
                                <th scope="col">Description</th>
                                <th scope="col">Release Date</th>
                                <th scope="col">Ticket Price</th>
                                <th scope="col" colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="film in films.data" :key="film.id">
                                <th scope="row">{{ film.name }}</th>
                                <td><img :src=film.photo></td>
                                <td>{{ film.description }}</td>
                                <td>{{ film.release_date }}</td>
                                <td>{{ film.ticket_price }}</td>
                                <td><a :href="'/films/' + film.id+ '/' + film.name"  v-bind:title="film.title">View</a></td>
                                <!--                                <td><a href="#" v-on:click="editFilm(film.id)" data-target="#exampleModal"  data-toggle="modal" v-bind:title="film.title">Edit</a></td>-->
<!--                                <td><a href="#" v-bind:href="@{route('/')}" data-target="#exampleModal"  data-toggle="modal" v-bind:title="film.title" v-bind:id="id">View</a></td>-->
                                <td><a href="#" data-target="#exampleModal2" v-on:click="deleteId(film.id)"  data-toggle="modal" v-bind:id="id"  >Delete</a></td>
                            </tr>

                            </tbody>
                        </table>
                        <pagination :data="films" :limit="2" @pagination-change-page="filmLists">
                            <span slot="prev-nav">&lt; Previous</span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
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
            film: {
                "name": '',
                "photo": '',
                "description": '',
                "release_date": '',
                "ticket_price": '',
                "country": '',
                "rating" : '',
                'genre': ''
            },
            laravelData: {},
            films: {},
            id: '',
            succmsg:  true,
            showmodal: false,
            pagenumber: 1,
            actionmsg: '',
            slug: '',
        }
    },
    methods: {
        filmLists(page) {
            if (typeof page === 'undefined') {
                page = 1;
            }
            this.$http.get('http://127.0.0.1:8000/api/films?page='+ page).then((response) => {
                this.films = response.data;
                this.pagenumber = page;
            });
        },
        editFilm(filmid) {
            this.$http.get('http://127.0.0.1:8000/api/films/'+ filmid).
            then((data) => {
                this.film.name = data.data.data.name;
                this.film.description = data.data.data.description;
                this.film.release_date = data.data.data.release_date;
                this.film.ticket_price = data.data.data.ticket_price;
                this.film.rating = data.data.data.rating;
                this.id = filmid;
            });
        },
        updateFilm() {
            this.$http.put('http://127.0.0.1:8000/api/films/'+this.id,{
                'name': this.film.name,
                'description': this.film.description,
                'release_date': this.film.release_date,
                'ticket_price': this.film.ticket_price,
                'rating': this.film.rating
            }).
            then((data) => {
                this.succmsg = false;
                console.log(data);
                this.film.name = '';
                this.film.description = '';
                this.film.release_date = '';
                this.film.ticket_price = '';
                this.film.rating = '';
                var self = this;
                setTimeout(function(){
                    self.succmsg = true;
                },3000);
                this.actionmsg = "Data updated successfully";
                $('#exampleModal').modal('hide');
                this.filmLists(this.pagenumber);

            });
        },
        deleteId(filmid) {
            this.id = filmid;
        },
        deleteFilm() {
            this.$http.delete('http://127.0.0.1:8000/api/films/'+this.id).
            then((data) => {
                this.succmsg = false;;
                var self = this;
                setTimeout(function(){
                    self.succmsg = true;
                },3000);

                this.actionmsg = "Data deleted successfully";
                this.filmLists(this.pagenumber);
                $('#exampleModal2').modal('hide');

            });
        },
        hideModal() {
            $('#exampleModal2').modal('hide');
        }

    },
    mounted() {
        this.filmLists();
    },
    computed : {

    }
}
</script>
<style scoped>
img{
    height: 125px;
    width: 125px;
}
.succmsg {
    display: none;
}
.showmodal {
    display: none !important;
    opacity: 0;
}
</style>
