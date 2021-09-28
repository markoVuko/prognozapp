<template>
  <div id="cities-div">
      <div id="cities">
          <h2>Selected cities:</h2>
          <div class="city" v-for="city in this.cities" :key="city">
              <span>{{ city }}</span>
              <button class="btn btn-danger" @click="removeCity(city)"><b-icons-trash></b-icons-trash></button>
          </div>
          <div  v-if="this.cities.length == 0">
              <h4>Please select a city!</h4>
          </div>
      </div>

  </div>
</template>

<script>
export default {
    created(){
        this.cities = this.$props.cities;
    },
    data(){
        return {
            cities:[]
        }
    },
    methods:{
        removeCity(city){
            this.cities = this.cities.filter(x => x != city);
        }
    },
    props: ['cities']

}
</script>

<style>
@import '~bootstrap-icons/font/bootstrap-icons';
#cities {
    width:200px;
    min-height:100px;
    margin:auto;
    margin-top:15%;
}
</style>