<template>
  <div class="about">
    <h1>Колектив</h1>
  </div>
  <table>
    <tr v-for="d in data" :key="d.id">
  <PearsonCard :data="d"/>
  </tr>
  </table>
</template>
<script>
import PearsonCard from '../components/PearsonCard.vue';
import axios from 'axios'
import {Path} from '../config/config'



export default {
  name:'Kolektiv',
  components: {
   PearsonCard
  },
  data() {
    return {
      data:[],
      
    }
  },
  methods: {
  async fetchData(){
  await axios.get(`${Path}/kolektiv.php?`)
  .then((response)=> {
   
    console.log(response);
    this.data=response.data;
  })
  },
  },
  mounted(){
   this.fetchData();
  }
  
  
 
 
}
</script>