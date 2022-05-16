<template>

<el-row :gutter="0">
<el-col :sm="8" :md="10" :offset="1">
   <h1>Съдържание</h1>
 

<el-form :model="form" label-width="120px" >
    <el-form-item label="Резюме">
      <el-input v-model="form.summary" type="textarea" />
    </el-form-item>
    <el-form-item label="Цел">
      <el-input v-model="form.purpose" type="textarea"/>
    </el-form-item>
    <el-form-item label="Значение">
      <el-input v-model="form.meaning" type="textarea"/>
    </el-form-item>
     <el-form-item label="Предизвикателства">
      <el-input v-model="form.challenges" type="textarea"/>
    </el-form-item>
     <el-form-item label="Научна област">
      <el-input v-model="form.scientific_field" type="textarea"/>
    </el-form-item>
     <el-form-item label="За газовите хидрати">
      <el-input v-model="form.about" type="textarea"/>
    </el-form-item>
     
     
    
    
   

   <el-button type="warning" style="float: left;" @click="clean()">Изчисти</el-button>
    <el-form-item>
      
      <el-button type="primary" @click="onSubmit">Редактирай</el-button>
      
    </el-form-item>
    
    
  </el-form>
  
  </el-col>

  <el-col :span="10"  :offset="1">
 


  </el-col>
  </el-row>
 
</template>
<script  setup>
import { reactive } from 'vue'
import axios from 'axios'
import {Path} from '../config/config'
import { useRouter } from "vue-router";
import { onBeforeMount } from 'vue'






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
  await axios.get(`${Path}/getallwebsitedata.php`)
  .then((response)=> {
   
    
    data.data=response.data;
    
  })
  form.id=data.data[0].website_id;
  form.summary=data.data[0].Summary;
  form.purpose=data.data[0].Purpose;
  form.meaning=data.data[0].Meaning;
  form.challenges=data.data[0].Challenges;
  form.scientific_field=data.data[0]["Scientific field"];
  form.about=data.data[0].about;
}
const clean = () => {
  
  form.summary="";
  form.purpose="";
  form.meaning="";
  form.challenges="";
  form.scientific_field="";
  form.about="";
  
  

}




//const data=reactive({
//  wrongPass: false,
//})
// do not use same name with ref
const form = reactive({
    id:'',
  summary: '',
  purpose:'',
  meaning:'',
  challenges:'',
  scientific_field:'',
  about:'',
 
  
})

const onSubmit = () => {

   let formData = new FormData();
    formData.append('username', sessionStorage.username);
   formData.append('password', sessionStorage.pass);
   formData.append('id', form.id);
   formData.append('summary', form.summary.replace(/'/g, "''"));
   formData.append('purpose', form.purpose.replace(/'/g, "''"));
   formData.append('meaning', form.meaning.replace(/'/g, "''"));
   formData.append('challenges', form.challenges.replace(/'/g, "''"));
   formData.append('scientific_field', form.scientific_field.replace(/'/g, "''"));
   formData.append('about', form.about.replace(/'/g, "''"));
 

   axios.post(`${Path}/updatewebsite.php`,formData)
  .then((response)=> {
    
    console.log(response);
    
   loadData();
    
   
  });
 
 
}

</script>
<style>
label {display: inline !important;
        width: 160px !important;}


::-webkit-scrollbar{display:inline !important;}
textarea{
  resize: both;
}
</style>
