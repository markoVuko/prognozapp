<template>
  <div id="cities-div">
      <div id="cities">
          <h2>Subscriptions:</h2>
          <div id="c-list"   v-if="this.citiesC.length != 0">
              <div class="city" v-for="city in this.citiesC" :key="city">
              <span class="city-text">{{ citiesC.indexOf(city)+1 }}. {{ city }}</span>
              <button class="btn btn-danger" @click="removeCity(city)"><i class="fa fa-trash"></i></button>
          </div>
          </div>
          <div  v-if="this.cities.length == 0">
              <h4>Please select a city!</h4>
          </div>
      </div>

  </div>
</template>

<script>
import axios from 'axios'

export default {
    created(){
        this.citiesC = this.$props.cities;
    },
    data(){
        return {
            citiesC:[]
        }
    },
    methods:{
        removeCity(city){
            this.$emit("skloniGrad", city);
        }
    },
    props: ['cities'],
    watch:{    
            cities(){
                this.citiesC= this.cities;
            }    
        }

}
</script>

<style>

.city {
    border:1px solid lightgray;
    border-radius: 10px;
    padding: 6px;
    width:300px;
    margin-bottom:5px;
    background-color: white;
}

.city:hover {
    background-color: lightgreen;
    transform: scale(1.1, 1.1);
}

#c-list {
    max-height:300px;
    overflow: auto;
    padding: 10px 5px 10px 30px;
    border:1px solid lightgray;
    border-radius: 10px;
    background-color: #F6F6F6;
}

#cities {
    width:400px;
    margin:auto;
    margin-top:15%; 
}

.city-text {
    font-size:20px;
    margin-right:5px;
}

.city .btn {
    padding: 1px 5px 1px 5px;
    color:white;
    float:right;
}
</style>