<template>

<el-row :gutter="0">
<el-col :sm="8" :md="10" :offset="1">
   <h1>Добави Администратор</h1>
 

<el-form :model="form" label-width="120px" >
    <el-form-item label="Име">
      <el-input v-model="form.name" />
    </el-form-item>
    <el-form-item label="Парола">
      <el-input v-model="form.pass" />
    </el-form-item>
    
     
    
    
   

   <el-button type="warning" style="float: left;" @click="clean()">Изчисти</el-button>
    <el-form-item>
      
      <el-button type="primary" @click="onSubmit">Добави</el-button>
      
    </el-form-item>
    
    
  </el-form>
  
  </el-col>

  <el-col :span="10"  :offset="1">
 
<el-table :data="data.data" height="250" style="width: 300px">

    <el-table-column prop="username" label="Име" width="150" />
   
    <el-table-column  label="" width="80">
      <template #default="scope">
        <el-button type="text" size="small" @click="editUsers(scope.row.user_id,scope.$index)"
          >Редактирай</el-button
        >
        
      </template>
    </el-table-column>
        <el-table-column  label="" width="50">
       <template #default="scope">
        <el-button type="danger" :icon="Delete" circle @click="deleteUser(scope.row.user_id,scope.$index)" />
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
import hash from 'object-hash';
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
  if(sessionStorage.access!=1){
     router.push({path: `/Login`});
  }
  loadData();
})


async function loadData(){
  await axios.get(`${Path}/getusers.php`)
  .then((response)=> {
   
    console.log(response);
    data.data=response.data;
    console.log(data);
  })
  
}
const clean = () => {
  form.name="";
  form.pass="";
  
  editid=0;
  edit = false;

}
const editUsers = (id,index) => {
  form.name=data.data[index].username;
  form.pass="";
  editid=id;
  edit = true;

}
const deleteUser = (id,index) => {
  if(Number(id)!==1){
  let formData = new FormData();
   formData.append('username', sessionStorage.username);
   formData.append('password', sessionStorage.pass);
   formData.append('id', id);
  
 
   axios.post(`${Path}/deleteUser.php`,formData)
  .then((response)=> {
    
    console.log(response);
    
  
    
   
  });
 data.data.splice(index, 1);}
}



//const data=reactive({
//  wrongPass: false,
//})
// do not use same name with ref
const form = reactive({
  name: '',
  pass:'',
 
 
  
})

const onSubmit = () => {

   let formData = new FormData();
    formData.append('username', sessionStorage.username);
   formData.append('password', sessionStorage.pass);


   formData.append('id', editid);
   formData.append('name', form.name);
   formData.append('pass', hash(form.pass));
   
   if(edit == false){
   axios.post(`${Path}/adduser.php`,formData)
  .then((response)=> {
    
    console.log(response);
    
   loadData();
    
   
  });
 }else{
   axios.post(`${Path}/updateuser.php`,formData)
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
