<template>

<el-row :gutter="0">
<el-col :sm="8" :md="10" :offset="1">
   <h1>Добави Файлове</h1>
 

<el-form :model="form" label-width="120px" >
    <el-form-item label="Име">
      <el-input v-model="form.name" />
    </el-form-item>
    <el-form-item label="Достъпен публично:">
      <el-switch v-model="form.access" />
    </el-form-item>
     <el-form-item label="Картинка">
      <input type="file" ref="file" @change="handleFileUpload( $event )">
    </el-form-item>
     
    
    
   

   <el-button type="warning" style="float: left;" @click="clean()">Изчисти</el-button>
    <el-form-item>
      
      <el-button type="primary" @click="onSubmit">Добави</el-button>
      
    </el-form-item>
    
    
  </el-form>
  
  </el-col>

  <el-col :span="10"  :offset="1">
 
<el-table :data="data.data" height="250" style="width: 300px">

    
   
    <el-table-column  label="Име" width="150">
      <template #default="scope">
        <a :href="getfileUrl(scope.row.path)" >{{scope.row.name}}</a>
      </template>
    </el-table-column>
     <el-table-column  label="Публичен" width="100">
      <template #default="scope">
        <el-switch v-model="scope.row.access" active-value="1"
      inactive-value="0" @click="updateFile(scope.row.file_id,scope.row.access)"/>
      </template>
    </el-table-column>
        <el-table-column  label="" width="50">
       <template #default="scope">
        <el-button type="danger" :icon="Delete" circle @click="deleteFile(scope.row.file_id,scope.$index,scope.row.path)" />
      </template>
    </el-table-column>
    
    
  </el-table>

  </el-col>
  </el-row>
 
</template>
<script  setup>
import { ref} from "vue"
import { reactive } from 'vue'
import { useRouter } from "vue-router";
import axios from 'axios'
import {Path} from '../config/config'
import { onBeforeMount } from 'vue'
import {
  
  Delete,
 
} from '@element-plus/icons-vue'

 const file = ref(null);



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
  await axios.get(`${Path}/allfiles.php`)
  .then((response)=> {
   
    console.log(response);
    data.data=response.data;
    console.log(data);
  })
  
}
const clean = () => {
  form.name="";
  form.access=false;


}

const deleteFile = (id,index,path) => {
  let formData = new FormData();
   formData.append('id', id);
   formData.append('path', path);
  
 
   axios.post(`${Path}/deletefile.php`,formData)
  .then((response)=> {
    
    console.log(response);
    
  
    
   
  });
 data.data.splice(index, 1);
}
const updateFile = (id,access) => {
  let formData = new FormData();
   formData.append('id', id);
   formData.append('access', access);
  
 
   axios.post(`${Path}/updatefile.php`,formData)
  .then((response)=> {
    
    console.log(response);
    
  
    
   
  });
}



const form = reactive({
  name: '',
  access:false
 
  
})
const handleFileUpload = (event)=> {
  file.value=event.target.files[0];
  console.log(event.target.files);
  
}
const onSubmit = () => {

   let formData = new FormData();
   formData.append('username', sessionStorage.username);
   formData.append('password', sessionStorage.pass);
   formData.append('name', form.name);
   if(form.access===true){
   formData.append('access', 1);}else{
       formData.append('access', 0);
   }

   formData.append('file', file.value);
 
   
   axios.post(`${Path}/addfile.php`,formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
  .then((response)=> {
    
    console.log(response);
    
   loadData();
    
   
  });
 
 
}
 function getfileUrl(path){
       var src = Path+'/getfile.php?path='+ path;
      //var images = require.context('../../public/images', false)
    //return images('./' + this.data.pic)
    return src;
    }
</script>
<style>
label {display: inline !important;
        width: 160px !important;}


</style>
