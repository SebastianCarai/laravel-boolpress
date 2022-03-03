<template>
    <section>
        <div class="container">
            <h1 class="text-center">Blog</h1>

            <Posts />
        </div>
    </section>
</template>

<script>
import Posts from '../components/Posts.vue';

export default {
    name: 'Blog',
    components:{
        Posts
    }
}
</script>