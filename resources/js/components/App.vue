<template>
  <div>
    <navbar :user="user" />
    <div id="content-wrapper">
      <city-selector @gradJeIzabran="preuzmiGrad($event)" />
      <city-list :cities="gradoviZaListu" />
      <div id="empty"></div>
    </div>
  </div>
</template>

<script>
import Navbar from './Navbar.vue';
import CitySelector from './CitySelector.vue';
import CityList from './CityList.vue';
import axios from 'axios'
import Vue from 'vue';

export default {
  created(){
    this.uzmiInfo();
  },
  data(){
    return {
      gradoviZaListu:[],
      user:{}
    }
  },
  methods:{
    uzmiInfo(){
      axios.get('/getInfo').then((response) => {
        console.log(response);
        //Vue.$set(this.user,"name",response.data.name);
        this.user = response.data;
      })
      .catch(error =>{
        console.log(error);
      });
    },
    preuzmiGrad(grad){
      if(this.gradoviZaListu.length >= 10){
        alert("You have reached your limit of 10 city subscriptions.");
        return;
      }
      if(this.gradoviZaListu.filter(x => x == grad).length > 0){
        alert("You have already selected this city.");
        return;
      }
      this.gradoviZaListu.push(grad);
    }
  },
  components:{
    Navbar,
    CitySelector,
    CityList
  }

}
</script>

<style>
#content-wrapper {
  width:100%;
}
#empty{
  width:100%;
  height:300px;
  float:left;
}
#selector-div, #cities-div {
  height:500px;
  width:45%;
  float:left;
}
</style>