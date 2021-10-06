<template>
  <div  id="selector-div">


                    <form @submit.prevent="" id="selector-form">
                        <h3>Subscribe to a city</h3>
                        <label for="city-select">City</label>
                        <select  class="form-control" name="city-select" id="city-select" v-model="izabraniGrad">
                            <option v-for="g in gradovi" :key="g" :value="g">{{ g }}</option>
                        </select>
                        <button class="btn btn-primary" type="submit" @click="izaberiGrad()">Subscribe</button>
                    </form>

                <form @submit.prevent="" id="time-form">
                        <h3>Schedule your update</h3>
                        <label for="time-select">Time:</label>
                        <select  class="form-control" name="time-select" id="time-select" v-model="izabranoVreme">
                            <option v-for="v in vremena" :key="v" :value="v">{{ v }}</option>
                        </select>
                        <button class="btn btn-primary" type="submit" @click="izaberiVreme()">Schedule</button>
                    </form>



  </div>
</template>

<script>
import axios from 'axios'

export default {
    data(){
        return {
            izabraniGrad:null,
            izabranoVreme:null,
            vremena:[
                '01:00',
                '02:00',
                '03:00',
                '04:00',
                '05:00',
                '06:00',
                '07:00',
                '08:00',
                '09:00',
                '10:00',
                '11:00',
                '12:00',
                '13:00',
                '14:00',
                '15:00',
                '16:00',
                '17:00',
                '18:00',
                '19:00',
                '20:00',
                '21:00',
                '22:00',
                '23:00'
            ],
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
        izaberiVreme(){
            if(this.izabranoVreme == null){
                alert("You haven't chosen a time!");
                return;
            }
            const config = { headers: { Authorization: `Bearer ${this.$props.user.token}`}};
            console.log(config);
            axios.put('/api/users/'+this.$props.user.id, {mail_time:this.izabranoVreme}, config).then((response) => {
                console.log(response);
                alert("You have scheduled your mailing time successfully!");
            })
            .catch(error =>{
                console.log(error);
            });
        },
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
    },
    props:['user']

}
</script>

<style>

#selector-form, #time-form {
 width:50%;
 height:200px;
 margin-left:40%;
 margin-top:15%;
}

#city-select, #time-select {
    width:150px;
}




.btn {
    margin-top:7px;
    color:white;
}
</style>
