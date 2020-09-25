<template>
    <div id="postsrec">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="card">
                        <img class="card-img-top" :src=film.photo alt="Photo">
                        <div class="card-body">
                            <h5 class="card-title">{{film.name}}</h5>
                            <p class="card-text">{{ film.description}}</p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Release Date:</strong> {{ film.release_date}}</li>
                            <li class="list-group-item"><strong>Ticket Price:</strong> {{ film.ticket_price}}</li>
                            <li class="list-group-item"><strong>Rating:</strong> {{ film.rating}}</li>
                            <li class="list-group-item"><strong>Country:</strong> {{ this.country}}</li>
                            <li class="list-group-item"><strong>Genre:</strong> {{ this.genreTags}}</li>
                        </ul>
                        <div class="card-body">
                            <strong>Comments</strong>
                            <ul v-for="comment in comments" :key="film.id">
                                <li scope="row"> <strong>Name => </strong>{{ comment.name }} | <strong>Comment => </strong>{{ comment.comment }} @ {{ comment.created_at }}</li>
                              </ul>
                         </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div v-bind:class="{ succmsg: succmsg }">
                        <div class="col-md-12 col-lg-12">
                            <div class="alert alert-success">Comment Posted Successfully</div>
                        </div>
                    </div>
                    <h2>Comments</h2>
                    <form method="post" name="addComment" id="addComment" action="#" @submit.prevent="addComment">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" v-model="comment.name"/>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea name="comment" id="comment" class="form-control" placeholder="Comment" v-model="comment.comment"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- Button trigger modal -->
                <!-- Modal -->

            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
export default {

    data() {
        return {
            // film: {
            //     "name": '',
            //     "photo": '',
            //     "description": '',
            //     "release_date": '',
            //     "ticket_price": '',
            //     "country": '',
            //     "rating" : '',
            //     'genre': ''
            // },
            film: {},
            comment:{},
            comments:{},
            id: this.$attrs.id,
            succmsg:  true,
        }
    },
    methods: {
        filmLists() {
            this.$http.get('http://127.0.0.1:8000/api/films/'+ this.$attrs.id).then((response) => {
                this.film = response.data.data;
                this.comments = response.data.data.comments
            });
        },
        addComment() {
            var formatted_date = new Date().toJSON().slice(0,18).replace(/-/g,'/');
            this.comments.push({
                name: this.comment.name,
                comment: this.comment.comment,
                created_at: moment().format('YYYY-M-D h:mm:ss')
            });
            var formData = {
                'name' : this.comment.name,
                'comment' : this.comment.comment,
                'film' : this.id,
            }
            this.$http.post('http://127.0.0.1:8000/api/comments/',formData,{'Content-Type': 'application/x-www-form-urlencoded'}).
            then((data) => {
                this.succmsg = false;
                this.comment.name = '';
                this.comment.comment = '';
                this.comment.film_id = '';
                var self = this;
                setTimeout(function(){
                    self.succmsg = true;
                },3000);
            }).catch((error) => {
                console.log(error.status)
                this.errors_exist = true;
                if (error.status === 422) {
                    this.errors = error.data.message || {};
                } else {
                    this.errors = [];
                }
                console.log(this.errors);
            });
            // this.$http.put('http://127.0.0.1:8000/api/films/'+this.id,{
            //     'name': this.comment.name,
            //     'description': this.comment.comment,
            // }).
            // then((data) => {
            //     this.succmsg = false;
            //     console.log(data);
            //     this.film.name = '';
            //     this.film.description = '';
            //     this.film.release_date = '';
            //     this.film.ticket_price = '';
            //     this.film.rating = '';
            //     var self = this;
            //     setTimeout(function(){
            //         self.succmsg = true;
            //     },3000);
            //     this.actionmsg = "Data updated successfully";
            //     $('#exampleModal').modal('hide');
            //     this.filmLists(this.pagenumber);
            //
            // });
        },
    },
    mounted() {
        this.filmLists();
    },
    computed :{
        genreTags() {
            var genre = [];
            if(this.film.genre){
                genre = this.film.genre.map(opt => opt.title);
            }
            return genre;
        },
        country() {
            var country;
            if(this.film.genre){
                country = this.film.country.name;
            }
            return country;
        }
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
