<template>
    <section>
        <div class="container py-4">
            <h1>Lista dei post</h1>

            <div class="row row-cols-3">
                <div class="col my-3" v-for="(post,index) in posts" :key="index">
                    <div class="card" style="width: 18rem;">
                        <img v-if="post.cover" :src="post.cover" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ post.title}}</h5>
                            <p class="card-text">{{ cutContentText(post.content, 50)}}</p>
                            <!-- This router link redirects to the post detail page -->
                            <router-link :to="{name: 'post-details', params:{slug : post.slug}}">Leggi il post</router-link>
                        </div>
                    </div>
                </div>             
            </div>

            <!-- Pagination NAV -->
            <div class="d-flex justify-content-center">
                <ul class="pagination">
                    <!-- Previous btn -->
                    <li class="page-item" :class="{disabled : this.currentPage===1}">
                        <a class="page-link" @click="postsApiCall(currentPage - 1)">Previous</a>
                    </li>
                    <!-- Number links -->
                    <li class="page-item" v-for="n in lastPage" :key="n" @click="postsApiCall(n)">
                        <a class="page-link">{{n}}</a>
                    </li> 
                    <!-- Next btn -->
                    <li class="page-item" :class="{disabled : this.currentPage===this.lastPage}" >
                        <a class="page-link" @click="postsApiCall(currentPage + 1)">Next</a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'Posts',
    data: function(){
        return{
            posts: [],
            postsPerPage: false,
            currentPage: 1,
            lastPage: false,
        }
    },
    methods:{

        // Axios call to the api created in the Api/PostController
        // When the user clicks 'previous' and 'next' buttons, the param "page" changes, and the API return other posts
        postsApiCall : function(pageToSearch){
            axios.get('http://127.0.0.1:8000/api/posts', {
                params:{
                    page : pageToSearch
                }
            })
            .then((response) =>{
                this.posts = response.data.posts.data;
                this.postsPerPage = response.data.posts.per_page;
                this.currentPage = response.data.posts.current_page;
                this.lastPage = response.data.posts.last_page
            });
        },

        // If the post content is longer than 50 characters, this function cuts it and adds '...' at the end
        cutContentText: function(textToCut, maxChar){
            if (textToCut.length > maxChar){
                return textToCut.substring(0,50) + '...';
            }else{
                return textToCut
            }
        }
    },
    created: function(){
        this.postsApiCall(this.currentPage);
    }
}
</script>