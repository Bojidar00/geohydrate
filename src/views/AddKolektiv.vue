<template>

<el-row :gutter="0">
<el-col :sm="8" :md="10" :offset="1">
   <h1>Добави колектив</h1>
 

<el-form :model="form" label-width="120px" >
    <el-form-item label="Име">
      <el-input v-model="form.name" />
    </el-form-item>
    <el-form-item label="Месторабота">
      <el-input v-model="form.job_location" />
    </el-form-item>
     <el-form-item label="Образование">
      <el-input v-model="form.education" />
    </el-form-item>
     <el-form-item label="Длъжност, последни 5 години">
      <el-input v-model="form.last_job" />
    </el-form-item>
     <el-form-item label="Област на работа">
      <el-input v-model="form.job" />
    </el-form-item>
    <el-form-item label="e-mail">
      <el-input v-model="form.email" />
    </el-form-item>
   

   <el-button type="warning" style="float: left;" @click="clean()">Изчисти</el-button>
    <el-form-item>
      
      <el-button type="primary" @click="onSubmit">Добави</el-button>
      
    </el-form-item>
    
    
  </el-form>
  
  </el-col>

  <el-col :span="10"  :offset="1">
 
<el-table :data="data.data" height="250" style="width: 800px">

    <el-table-column prop="name" label="Име" width="150" />
    <el-table-column prop="email" label="email" width="170" />
    <el-table-column  label="" width="80">
      <template #default="scope">
        <el-button type="text" size="small" @click="editKolektiv(scope.row.pearson_id,scope.$index)"
          >Редактирай</el-button
        >
        
      </template>
    </el-table-column>
        <el-table-column  label="" width="50">
       <template #default="scope">
        <el-button type="danger" :icon="Delete" circle @click="deleteKolektiv(scope.row.pearson_id,scope.$index)" />
      </template>
    </el-table-column>
    
    
  </el-table>

  </el-col>
  </el-row>
 
</template>
<script  setup>
import { reactive } from 'vue'
import axios from 'axios'
import {Path} from '../config/config'
import { useRouter } from "vue-router";
import { onBeforeMount } from 'vue'
import {
  
  Delete,
 
} from '@element-plus/icons-vue'

let edit = false;
let editid=0;
const data=reactive({
  data: [],
})
const router =useRouter();
onBeforeMount( ()=>{
  if(!sessionStorage.username){
     router.push({path: `/Login`});
  }
  loadData();
})


async function loadData(){
  await axios.get(`${Path}/kolektiv.php`)
  .then((response)=> {
   
    console.log(response);
    data.data=response.data;
    console.log(data);
  })
  
}
const clean = () => {
  form.name="";
  form.job_location="";
  form.education="";
  form.last_job="";
  form.job="";
  form.email="";
  editid=0;
  edit = false;

}
const editKolektiv = (id,index) => {
  form.name=data.data[index].name;
  form.job_location=data.data[index].job_location;
  form.education=data.data[index].education;
  form.last_job=data.data[index].last_job;
  form.job=data.data[index].job;
  form.email=data.data[index].email;
  editid=id;
  edit = true;

}
const deleteKolektiv = (id,index) => {
  let formData = new FormData();
   formData.append('id', id);
  
 
   axios.post(`${Path}/deletekolektiv.php`,formData,{params:{name:"admin",pass:"admin"}})
  .then((response)=> {
    
    console.log(response);
    
  
    
   
  });
 data.data.splice(index, 1);
}



//const data=reactive({
//  wrongPass: false,
//})
// do not use same name with ref
const form = reactive({
  name: '',
  job_location:'',
  education:'',
  last_job:'',
  job:'',
  email:'',
})

const onSubmit = () => {

   let formData = new FormData();
   formData.append('id', editid);
   formData.append('name', form.name);
   formData.append('job_location', form.job_location);
   formData.append('education', form.education);
   formData.append('last_job', form.last_job);
   formData.append('job', form.job);
   formData.append('email', form.email);
   if(edit == false){
   axios.post(`${Path}/addkolektiv.php`,formData,{params:{name:"admin",pass:"admin"}})
  .then((response)=> {
    
    console.log(response);
    
   loadData();
    
   
  });
 }else{
   axios.post(`${Path}/updatekolektiv.php`,formData,{params:{name:"admin",pass:"admin"}})
  .then((response)=> {
    
    console.log(response);
    
   loadData();
    
   
  });
 }
 
 
}

</script>
<style>
label {display: inline !important;
        width: 160px !important;}


</style>
