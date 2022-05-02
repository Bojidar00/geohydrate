<template>
  
    <h1>Вход</h1>
 
<el-row :gutter="0">
<el-col :span="11" :offset="5">

 <el-form :model="form" label-width="120px" >
    <el-form-item label="Име">
      <el-input v-model="form.name" />
    </el-form-item>
    <el-form-item label="Парола">
      <el-input v-model="form.pass" />
    </el-form-item>
   

   
    <el-form-item>
      <el-button type="primary" @click="onSubmit">Вход</el-button>
      
    </el-form-item>
    <div v-if:="data.wrongPass" class="red">
      Грешно име или парола!
    </div>
    
  </el-form>
  </el-col>
</el-row>




</template>
<script setup>
import { reactive } from 'vue'
import axios from 'axios'
import {Path} from '../config/config'
import { useRouter } from "vue-router";
import hash from 'object-hash';
import { onBeforeMount } from 'vue'

const router =useRouter();

onBeforeMount( ()=>{
  if(sessionStorage.username){
    router.push({path: `/AdminPanel/AddData`});
  }
   
})


const data=reactive({
  wrongPass: false,
})
// do not use same name with ref
const form = reactive({
  name: '',
  pass:'',
})

const onSubmit = () => {
 
   let formData = new FormData();
   formData.append('name', form.name);
   formData.append('pass', hash(form.pass));
   console.log(hash(form.pass));
  console.log('submit!');
   axios.post(`${Path}/login.php`,formData,{params:{name:"admin",pass:"admin"}})
  .then((response)=> {
    
    console.log(response);
    
  
    if(response.data[0]!=null){
      if (response.data[0].access==1 || response.data[0].access==2){
      sessionStorage.username=form.name;
      sessionStorage.pass=hash(form.pass);
      sessionStorage.access=response.data[0].access;
      router.push({path: `/AdminPanel/AddData`});}
    }else{
      data.wrongPass=true;
    }
   
  });
  
 
}


</script>

<style>
input{
    width:100% !important;
}
#form{
    text-align: center !important;
}
button{
    text-align: center !important;
    display: block !important;
    margin: 0 auto !important;
}
.red{
  color: red;
}

</style>