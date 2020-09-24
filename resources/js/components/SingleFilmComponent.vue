<template>
    <div id="postsrec">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="col-6">
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
                            <li class="list-group-item"><strong>Country:</strong> {{ film.country.name}}</li>
                            <li class="list-group-item"><strong>Genre:</strong> {{ this.genreTags}}</li>
                        </ul>
                        <div class="card-body">
                            <!--                        <a href="#" class="card-link">Card link</a>-->
                            <!--                        <a href="#" class="card-link">Another link</a>-->
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    Comment Section will be here
                </div>
                <!-- Button trigger modal -->
                <!-- Modal -->

            </div>
        </div>
    </div>
</template>
<script>

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
            id: '',
        }
    },
    methods: {
        filmLists() {
            this.$http.get('http://127.0.0.1:8000/api/films/'+ this.$attrs.id).then((response) => {
                this.film = response.data.data;
            });
        },
    },
    mounted() {
        this.filmLists();
    },
    computed :{
        genreTags() {
           return this.film.genre.map(opt => opt.title);
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
