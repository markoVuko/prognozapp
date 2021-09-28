<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container px-lg-5">
                <a class="navbar-brand" href="#!">PrognozApp</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">{{ user.name }}</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="#!" v-on:click="logout($event)">Logout</a>
                        
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
</template>

<script>
import axios from 'axios'

export default {
    methods:{
        logout(e){
            e.preventDefault();
            axios.post('/logout').then((response) => {
                console.log(response);
                location.reload();
            })
            .catch(error =>{
                console.log(error);
            });
        }
    },
    mounted(){
        console.log("uspesno");
    },
    props:['user']

}
</script>

<style>

</style>