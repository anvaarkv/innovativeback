<template>
    <div class="container">
        <div v-bind:class="{ succmsg: succmsg }">
            <div class="col-md-12 col-lg-12">
                <div class="alert alert-success">Data inserted successfully</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 com-lg-7  offset-md-3">
                <div v-if="errors_exist" class="alert alert-danger" role="alert">
                    Whoops! Something Invalid.
                    <ul>
                        <div v-for="error in errors">
                            <li>{{ error[0] }}</li>
                        </div>
                    </ul>
                </div>
                <form method = "post" name="addfilm" id="addfilm" action="#" enctype="multipart/form-data" @submit.prevent="addFilm">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" v-model="film.name"/>
                        {{ film.name }}
                    </div>
                    <div class="form-group">
                        <label for="photo">Photo</label>
                        <input type="file" name="photo" id="photo" class="form-control" placeholder="Photo" v-on="film.photo"/>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Description" v-model="film.description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="release_date">Release Date</label>
                        <input type="date" name="release_date" id="release_date" class="form-control" placeholder="Release Date" v-model="film.release_date"/>
                    </div>
                    <div class="form-group">
                        <label for="ticket_price">Ticket Price</label>
                        <input type="text" name="ticket_price" id="ticket_price" class="form-control" placeholder="Ticket Price" v-model="film.ticket_price"/>
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <tags-input element-id="genre"
                                    v-model="selectedTags"
                                    :typeahead="true"></tags-input>
<!--                        <input type="text" class="form-control" id="genre" name="genre" data-role="tagsinput">-->

                    </div>
                    <div class="form-group">
                        <label for="country">Country</label>
                        <select name="country" class='form-control' v-model='film.country'>
                            <option value='0' >Select Country</option>
                            <option v-for='country in countries' :value='country.id'>{{ country.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rating">Ratings</label>
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
</template>
<script>


export default {
    components: { "tags-input": VoerroTagsInput },
    data() {
        return {
            selectedTags: [
                { key: 'comedy', value: 'Comedy' },
                { key: 'thriller', value: 'Thriller' }
            ],
            country: 0,
            countries: [],
            film: {
                "name": '',
                "photo": '',
                "description": '',
                "release_date": '',
                "ticket_price": '',
                "rating" : ''
            },
            errors_exist : false,
            errors: [],
            succmsg:  true,
        }
    },
    methods: {
        addFilm() {
            var formData = new FormData;
            formData.append("photo", $('input[name="photo"]')[0].files[0] ?? '');
            formData.append("name",this.film.name)
            formData.append("description",this.film.description)
            formData.append("release_date",this.film.release_date)
            formData.append("ticket_price",this.film.ticket_price)
            formData.append("country",this.film.country ?? '')
            formData.append("rating",this.film.rating)
            var obj2 = JSON.stringify(this.selectedTags)
            formData.append("genre",this.selectedTags.length != 0 ? obj2 : '')
            this.$http.post('http://127.0.0.1:8000/api/films',formData,{'Content-Type': 'application/x-www-form-urlencoded'}).
            then((data) => {
                this.succmsg = false;
                this.film.name = '';
                this.film.description = '';
                this.film.release_date = '';
                this.film.ticket_price = '';
                this.film.rating = '';
                this.film.genre = '';
                var self = this;
                setTimeout(function(){
                    self.succmsg = true;
                },3000);
            }).catch((error) => {
                console.log(error.status)
                    this.errors_exist = true;
                    if(error.status === 422) {
                        this.errors = error.data.message || {};
                    }
                    else {
                        this.errors = [];
                    }
                    console.log(this.errors);
            })},
        getCountries() {
            this.$http.get('http://127.0.0.1:8000/countries')
                .then(function (response) {
                    this.countries = response.data;
                }.bind(this));
        }

    },
    computed: {

    },
    created: function(){
        this.getCountries()
    }
}
</script>
<style scoped>
.succmsg {
    display: none;
}
</style>
