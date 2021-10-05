<template>
  <div>
    <navbar :user="user" />
    <div id="content-wrapper">
      <city-selector @gradJeIzabran="preuzmiGrad($event)" :user="user" />
      <city-list :cities="gradoviZaListu" @skloniGrad="skloni($event)" />
      <div id="empty"></div>
    </div>
  </div>
</template>

<script>
import Navbar from './Navbar.vue';
import CitySelector from './CitySelector.vue';
import CityList from './CityList.vue';
import axios from 'axios'
import "bootstrap/dist/css/bootstrap.min.css"

export default {
  created(){
    this.uzmiInfo();
    this.uzmiGradove();

  },
  data(){
    return {
      gradoviZaListu:['a'],
      user:{}
    }
  },
  methods:{
    uzmiGradove(){
      axios.get('/cities').then((response) => {
        console.log(response);
        this.gradoviZaListu=[];
        response.data.forEach((c)=>{
          this.gradoviZaListu.push(c.city_name);
        });
      })
      .catch(error =>{
        console.log(error);
      });
    },
    skloni(g){
      axios.delete(`/cities/${g}`).then((response) => {
        console.log(response);
        this.gradoviZaListu=[];
        response.data.forEach((c)=>{
          this.gradoviZaListu.push(c.city_name);
        });
      })
      .catch(error =>{
        console.log(error);
      });
    },
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

      axios.post(`/cities/${grad}`).then((response) => {
            console.log(response);
            this.gradoviZaListu = [];
            response.data.forEach((c)=>{
              this.gradoviZaListu.push(c.city_name);
            });
            console.log(this.gradoviZaListu);
          })
        .catch(error =>{
                console.log(error);
        });


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
