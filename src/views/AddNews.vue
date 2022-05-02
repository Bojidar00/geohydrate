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

    <el-table-column prop="title" label="Име" width="150" />
   
    <el-table-column  label="" width="80">
      <template #default="scope">
        <el-button type="text" size="small" @click="editNews(scope.row.news_id,scope.$index)"
          >Редактирай</el-button
        >
        
      </template>
    </el-table-column>
        <el-table-column  label="" width="50">
       <template #default="scope">
        <el-button type="danger" :icon="Delete" circle @click="deleteNews(scope.row.news_id,scope.$index)" />
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
  
  Delete,
 
} from '@element-plus/icons-vue'

 const file = ref(null);

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
  await axios.get(`${Path}/allnews.php`)
  .then((response)=> {
   
    console.log(response);
    data.data=response.data;
    console.log(data);
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
  editid=id;
  edit = true;

}
const deleteNews = (id,index) => {
  let formData = new FormData();
   formData.append('id', id);
  
 
   axios.post(`${Path}/deletenews.php`,formData,{params:{name:"admin",pass:"admin"}})
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
  title: '',
  content:'',
  pic:'',
 
  
})
const handleFileUpload = (event)=> {
  file.value=event.target.files[0];
  console.log(event.target.files);
  
}
const onSubmit = () => {

   let formData = new FormData();
   formData.append('id', editid);
   formData.append('title', form.title);
   formData.append('content', form.content);
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
   axios.post(`${Path}/updatenews.php`,formData,{params:{name:"admin",pass:"admin"}})
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
