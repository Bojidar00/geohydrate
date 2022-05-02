<template>
  <el-row :gutter="10">
    <el-col :span="4"></el-col>
    <el-col :span="16">
      <div v-html="data.data"> </div>
    </el-col>
    <el-col :span="4"></el-col>
  </el-row>
</template>
<script setup>
import { onBeforeMount } from 'vue'
import axios from 'axios'
import {Path} from '../config/config'
import { reactive } from 'vue'

const data=reactive({
  data: [],
})


 onBeforeMount( ()=>{
  loadData();
   
}); 



async function loadData(){
  await axios.get(`${Path}/getAbout.php`)
  .then((response)=> {
   
    console.log(response);
    data.data=response.data[0].about;
    console.log(data);
    console.log(data.data);
  })
  
}

</script>
