<template>
  <div id="selector-div">
      <form @submit.prevent="" id="selector-form">
          <label for="city-select">Choose a city</label>
          <select  class="form-control" name="city-select" id="city-select" v-model="izabraniGrad">
            <option v-for="g in gradovi" :key="g" :value="g">{{ g }}</option>
          </select>
          <button class="btn btn-primary" type="submit" @click="izaberiGrad()">Subscribe</button>
      </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
    data(){
        return {
            izabraniGrad:null,
            gradovi:[
                "Tirana",
                "Andorra la Vella",
                "Vienna",
                "Minsk",
                "Brussels",
                "Sarajevo",
                "Sofia",
                "Zagreb",
                "Prague",
                "Copenhagen",
                "Tallinn",
                "Helsinki",
                "Paris",
                "Berlin",
                "Athens",
                "Budapest",
                "Reykjavik",
                "Dublin",
                "Rome",
                "Riga",
                "Vaduz",
                "Vilnius",
                "Luxembourg",
                "Valletta",
                "Chisinau",
                "Monaco",
                "Podgorica",
                "Amsterdam",
                "Haag",
                "Skopje",
                "Oslo",
                "Warsaw",
                "Lisbon",
                "Bucharest",
                "Moscow",
                "San Marino",
                "Belgrade",
                "Bratislava",
                "Ljubljana",
                "Madrid",
                "Stockholm",
                "Bern",
                "Kiev",
                "London"

            ]
        }
    },
    methods:{
        izaberiGrad(){
            if(this.izabraniGrad == null){
                alert("You haven't chosen a city!");
                return;
            }

            this.$emit("gradJeIzabran",this.izabraniGrad);
        }
    },
    mounted(){
        console.log("uspesno");
    }

}
</script>

<style>
#selector-form {
 width:50%;
 height:200px;
 margin-left:40%;
 margin-top:15%;
}

#city-select {
    width:150px;
}

.btn {
    margin-top:7px;
    color:white;
}
</style>