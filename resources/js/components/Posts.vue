<template>
    <section>
        <div class="container py-4">
            <h1>Lista dei post</h1>

            <div class="row row-cols-3">
                <div class="col my-3" v-for="(post,index) in posts" :key="index">
                    <div class="card" style="width: 18rem;">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title">{{ post.title}}</h5>
                            <p class="card-text">{{ cutContentText(post.content, 50)}}</p>
                        </div>
                        <!-- <ul class="list-group list-group-flush">
                            <li class="list-group-item">An item</li>
                            <li class="list-group-item">A second item</li>
                            <li class="list-group-item">A third item</li>
                        </ul> -->
                        <!-- <div class="card-body">
                            <a href="#" class="card-link">Card link</a>
                            <a href="#" class="card-link">Another link</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'Posts',
    data: function(){
        return{
            posts: []
        }
    },
    methods:{
        // Axios call to the api created in the Api/PostController
        postsApiCall : function(){
            axios.get('http://127.0.0.1:8000/api/posts')
            .then((response) =>{
                this.posts = response.data.posts;
            });
        },
        cutContentText: function(textToCut, maxChar){
            if (textToCut.length > maxChar){
                return textToCut.substring(0,50) + '...';
            }else{
                return textToCut
            }
        }
    },
    created: function(){
        this.postsApiCall();
    }
}
</script>