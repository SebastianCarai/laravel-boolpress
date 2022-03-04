<template>
    <section>
        <div class="container">
            <h2 class="text-center mt-5">
                Spiacenti, pagina non trovata: <router-link :to="{name: 'blog'}">Torna al blog</router-link>
            </h2>
        </div>
    </section>
</template>

<script>
export default {
    name: 'NotFound'
}
</script>