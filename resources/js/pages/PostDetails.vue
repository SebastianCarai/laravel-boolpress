<template>
    <div class="container">
        <h1>{{post.title}}</h1>

        <div>
            <img :src="post.cover" alt="" style="max-width: 500px">
        </div>

        <h5 v-if="post.category">Category: {{post.category.name}}</h5>
        <h4>
            <router-link 
                class="badge badge-primary mr-2" 
                v-for="tag in post.tags" :key="tag.id"
                :to="{name: 'tag-details', params:{slug: tag.slug}}"
            >
                {{tag.name}}
            </router-link>
        </h4>
        <p>{{ post.content }}</p>
    </div>
</template>

<script>
export default {
    name: 'PostDetails',
    data: function(){
        return {
            post : false,
            
        }
    },
    methods:{
        getPostDetails: function(){
            axios.get('http://127.0.0.1:8000/api/posts/' + this.$route.params.slug)
            .then((response) =>{
                this.post = response.data.post_to_show;
                console.log(this.post.cover);
                // If the post does not exist, the user gets redirected to the Not Found Page
                if (!this.post){
                    this.$router.push({name: 'not-found'})
                }
            });


        }
    },
    created: function(){
        this.getPostDetails();
    }
}
</script>