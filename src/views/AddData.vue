<template>

<el-row :gutter="0">
<el-col :sm="8" :md="10" :offset="1">
   <h1>Добави Файлове</h1>
 

<el-form :model="form" label-width="120px" >
    <el-form-item label="Име">
      <el-input v-model="form.name" />
    </el-form-item>
    <el-form-item label="Описание">
      <el-input v-model="form.description" type="textarea"/>
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

  <el-col :span="12"  :offset="1">
 <el-input
        v-model="search"
        class="w-50 m-2"
        placeholder="Търси"
        :prefix-icon="Search"
        @input="SearchData"
      />
<el-table :data="data.data2" height="250" style="width: 800px">

    <el-table-column  label="" width="50">
      <template #default="scope">
      <el-button type="primary" :icon="Download" @click="downloadFile(scope.row.path)" circle/>
      </template>
    </el-table-column>
   
    <el-table-column  label="Име" width="300">
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
  
  Delete, Search, Download
 
} from '@element-plus/icons-vue'

 const file = ref(null);

const search = ref('');

const data=reactive({
  data: [],
  data2:[],
})
const router =useRouter();
onBeforeMount( ()=>{
  if(!sessionStorage.username){
     router.push({path: `/Login`});
  }
  loadData();

})

function SearchData(){
 
  data.data2=[];
  data.data.forEach(element => {
    if(element.name.startsWith(search.value)){
      data.data2.push(element);
    }
  });
  console.log(data.data2);
  if(search.value===""){loadData();}
}

async function loadData(){
  await axios.get(`${Path}/allfiles.php`)
  .then((response)=> {
   
    
    data.data=response.data;
    data.data2=response.data;
    console.log(response.data);
  })
  
}
const clean = () => {
  form.name="";
  form.access=false;


}

const deleteFile = (id,index,path) => {
  let formData = new FormData();
  formData.append('username', sessionStorage.username);
   formData.append('password', sessionStorage.pass);
   formData.append('id', id);
   formData.append('path', path);
  
 
   axios.post(`${Path}/deletefile.php`,formData)
  .then((response)=> {
    
    console.log(response);
    
  
    
   
  }); 
 data.data2.splice(index, 1);
 data.data.forEach(function(element, index, object) {
  
   if(element.file_id===id){
     object.splice(index, 1);
   }
 }); 


}
const updateFile = (id,access) => {
  let formData = new FormData();
  formData.append('username', sessionStorage.username);
   formData.append('password', sessionStorage.pass);
   formData.append('id', id);
   formData.append('access', access);
  
 
   axios.post(`${Path}/updatefile.php`,formData)
  .then((response)=> {
    
    console.log(response);
    
  
    
   
  });
}



const form = reactive({
  name: '',
  description:'',
  access:false
 
  
})
const handleFileUpload = (event)=> {
  file.value=event.target.files[0];
  
  
}
const onSubmit = () => {
  
   let formData = new FormData();
   formData.append('username', sessionStorage.username);
   formData.append('password', sessionStorage.pass);
   formData.append('name', form.name.replace(/'/g, "''"));
   formData.append('description', form.description.replace(/'/g, "''"));
   if(form.access===true){
   formData.append('access', 1);}else{
       formData.append('access', 0);
   }

   formData.append('file', file.value);
  console.log(form.name);
  console.log(form.description);
  console.log(file.value);
   console.log(sessionStorage.username);
   console.log(sessionStorage.pass);
  
   
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

    function downloadFile(path){
      let url=getfileUrl(path);
      let name  = url.split('/');
      name=name[name.length-1];
      axios.get(url, { responseType: 'blob' })
      .then(response => {
        const blob = new Blob([response.data])
        const link = document.createElement('a')
        link.href = URL.createObjectURL(blob)
        link.download = name
        document.body.appendChild(link);
        link.click()
       
      }).catch(console.error)
  
    }
</script>
<style>
label {display: inline !important;
        width: 160px !important;}


</style>
