<template>
    <section>
        <div class="container">
            <h1 class="mb-5">Contact us</h1>

            <h4 class="mb-3">Compile the following form to contact us</h4>

            <form>


                <div class="mb-3">
                    <label for="email" class="form-label">Insert your email</label>
                    <input type="email" class="form-control" id="email" name="email" v-model="email">
                </div>
                <!-- Displaying possible mail errors -->
                <div class="alert alert-danger" v-if="errors.email">
                    {{errors.email}}
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Insert your name</label>
                    <input type="text" class="form-control" id="name" name="name" v-model="name">
                </div>
                <!-- Displaying possible name errors -->
                <div class="alert alert-danger" v-if="errors.name">
                    {{errors.name}}
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Insert the content</label>
                    <textarea name="content" id="content" class="form-control" cols="30" rows="10" v-model="content"></textarea>
                </div>
                <!-- Displaying possible content errors -->
                <div class="alert alert-danger" v-if="errors.content">
                    {{errors.content}}
                </div>

                <button type="submit" @click.prevent="leadApiCall()" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </section>
</template>

<script>
export default {
    name: 'ContactUs',
    data: function(){
        return{
            email: '',
            name: '',
            content: '',
            errors : {},
        }
    },
    methods:{
        leadApiCall: function(){
            axios.post('/api/leads/store', {
                email : this.email,
                name : this.name,
                content : this.content
            }).then((response) =>{
                if (response.data.success){
                    // If there are no errors
                    this.email = '',
                    this.name = '',
                    this.content = ''
                }else{
                    // If there are some errors
                    this.errors = response.data.errors;
                }
            });
        }
    }
}
</script>