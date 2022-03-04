<template>
    <div class="container">
        <h1>{{ capitalizeFirstLetter( tag.name ) }}</h1>

        <h4 class="mt-5">Related Posts:</h4>
        <div v-if="relatedPosts.length > 0">
            <ul class="list-group">
                <li v-for="post in relatedPosts" :key="post.id" class="list-group-item">
                    <router-link :to="{name: 'post-details', params:{slug: post.slug}}">{{post.title}}</router-link>
                </li>
            </ul>
        </div>
        <div v-else>
            <div>Non ci sono post legati a questo tag</div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'TagDetails',
    data: function(){
        return{
            tag: false,
            relatedPosts: []
        }
    },
    methods:{
        getTagDetails: function(){
            axios.get('http://127.0.0.1:8000/api/tags/' + this.$route.params.slug)
            .then((response)=>{
                console.log(response.data);
                this.tag = response.data.tag_to_show;
                this.relatedPosts = response.data.tag_posts;
                if(!this.tag){
                    this.$router.push({name: 'not-found'})
                }
            });
        },
        capitalizeFirstLetter: function(text){
            return text.charAt(0).toUpperCase() + text.slice(1);
        }
    },
    created: function(){    
        this-this.getTagDetails();
    }
}
</script>