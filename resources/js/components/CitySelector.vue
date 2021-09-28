<template>
  <div id="selector-div">
      <form @submit.prevent="" id="selector-form">
          <label for="city-select">Choose a city</label>
          <select  class="form-control" name="city-select" id="city-select" v-model="izabraniGrad">
            <option v-for="g in gradovi" :key="g" :value="g">{{ g }}</option>
          </select>
          <br>
          <button class="btn btn-primary" type="submit" @click="izaberiGrad()">Confirm city</button>
      </form>
  </div>
</template>

<script>
export default {
    data(){
        return {
            izabraniGrad:null,
            gradovi:["Prvi","drugi","treci","cetvrti"]
        }
    },
    methods:{
        izaberiGrad(){
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
</style>