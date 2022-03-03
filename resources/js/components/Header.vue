<template>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <span class="navbar-brand" href="#">Navbar</span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item" v-for="(link,index) in routes" :key="index">
                                <router-link class="nav-link active" aria-current="page" :to="{name: link.name}">{{link.label}}</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
</template>

<script>
export default {
    name:'Header',
    data: function(){
        return {
            routes:[
                {
                    name: 'home',
                    label : 'Homepage'
                },
                {
                    name: 'about',
                    label : 'About us'
                },
                {
                    name: 'blog',
                    label : 'Blog'
                }
            ]
        }
    }
}
</script>