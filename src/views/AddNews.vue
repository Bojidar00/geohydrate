<template>

<el-row :gutter="0">
<el-col :sm="8" :md="10" :offset="1">
   <h1>Добави новина</h1>
 

<el-form :model="form" label-width="120px" >
    <el-form-item label="Заглавие">
      <el-input v-model="form.title" />
    </el-form-item>
    <el-form-item label="Текст">
      <el-input v-model="form.content" type="textarea"/>
    </el-form-item>
     <el-form-item label="Картинка">
      <input type="file" ref="file" @change="handleFileUpload( $event )" >
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
        @input="SearchNews"
      />
<el-table :data="data.data2" height="250" style="width: 800px">

    <el-table-column prop="title" label="Име" width="360" />
   
    <el-table-column  label="" width="80">
      <template #default="scope">
        <el-button type="text" size="small" @click="editNews(scope.row.news_id,scope.$index)"
          >Редактирай</el-button
        >
        
      </template>
    </el-table-column>
        <el-table-column  label="" width="50">
       <template #default="scope">
        <el-button type="danger" :icon="Delete" circle @click="deleteNews(scope.row.news_id,scope.row.pic,scope.$index)" />
      </template>
    </el-table-column>
    
    
  </el-table>

  </el-col>
  </el-row>
 
</template>
<script  setup>
import { ref} from "vue"
import { reactive } from 'vue'
import axios from 'axios'
import {Path} from '../config/config'
import { useRouter } from "vue-router";
import { onBeforeMount } from 'vue'
import {
  
  Delete, Search
 
} from '@element-plus/icons-vue'
const search = ref('');
 const file = ref(null);
let edit = false;
let editid=0;
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
function SearchNews(){
  
  data.data2=[];
  data.data.forEach(element => {
    if(element.title.startsWith(search.value)){
      data.data2.push(element);
    }
  });
  console.log(data.data2);
  if(search.value===""){loadData();}
}

async function loadData(){
  await axios.get(`${Path}/allnews.php`)
  .then((response)=> {
   
    
    data.data=response.data;
    data.data2=response.data;
    
  })
  
}
const clean = () => {
  form.title="";
  form.content="";
  
  editid=0;
  edit = false;
  

}
const editNews = (id,index) => {
  form.title=data.data[index].title;
  form.content=data.data[index].content;
   form.path=data.data[index].pic;
  editid=id;
  edit = true;
 

}
const deleteNews = (id,path,index) => {
  let formData = new FormData();
  formData.append('username', sessionStorage.username);
   formData.append('password', sessionStorage.pass);
   formData.append('id', id);
    formData.append('path', path);
  
 
   axios.post(`${Path}/deletenews.php`,formData,)
  .then((response)=> {
    
    console.log(response);
    
  
    
   
  });
  data.data2.splice(index, 1);
 data.data.forEach(function(element, index, object) {
  
   if(element.news_id===id){
     object.splice(index, 1);
   }
 }); 
 
}




const form = reactive({
  title: '',
  content:'',
  pic:'',
  path:'',
 
  
})
const handleFileUpload = (event)=> {
  file.value=event.target.files[0];
 
  
}
const onSubmit = () => {

   let formData = new FormData();
   formData.append('username', sessionStorage.username);
   formData.append('password', sessionStorage.pass);
   formData.append('id', editid);
   formData.append('title', form.title.replace(/'/g, "''"));
   formData.append('content', form.content.replace(/'/g, "''"));
   formData.append('path', form.path);
   formData.append('file', file.value);
 
   if(edit == false){
   axios.post(`${Path}/addnews.php`,formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
              })
  .then((response)=> {
    console.log(response);
    
    
   loadData();
    
   
  });
 }else{
   axios.post(`${Path}/updatenews.php`,formData)
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
