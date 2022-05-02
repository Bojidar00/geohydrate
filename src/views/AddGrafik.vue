<template>

<el-row :gutter="0">
<el-col :sm="8" :md="10" :offset="1">
   <h1>Добави график</h1>
 

<el-form :model="form" label-width="120px" >
    <el-form-item label="Дейност">
      <el-input v-model="form.activity" />
    </el-form-item>
    <el-form-item label="Срок в месеци">
      <el-input v-model="form.deadline" />
    </el-form-item>
     <el-form-item label="Изпълнители:">
     <el-select
      v-model="value2"
      multiple
      collapse-tags
      placeholder="Избери"
      style="width: 240px"
    >
      <el-option
        v-for="item in options"
        :key="item.value"
        :label="item.label"
        :value="item.value"
      />
    </el-select>
    </el-form-item>

     <div v-for="v in form.results" :key="v.id">
    <el-form-item label="Резултат">
      <el-input v-model=v.value />
    </el-form-item>
    </div>
    <el-button type="success" style="" @click="AddResult">+</el-button>
    

   <el-button type="warning" style="float: left;" @click="clean()">Изчисти</el-button>
    <el-form-item>
      
      <el-button type="primary" @click="onSubmit">Добави</el-button>
      
    </el-form-item>
    
    
  </el-form>
  
  </el-col>

  <el-col :span="10"  :offset="1">
 
<el-table :data="data.data2" height="250" style="width: 800px">

    <el-table-column prop="activity" label="Дейност" width="150" />
    <el-table-column  label="" width="80">
      <template #default="scope">
        <el-button type="text" size="small" @click="editGrafik(scope.row.grafik_id,scope.$index)"
          >Редактирай</el-button
        >
        
      </template>
    </el-table-column>
        <el-table-column  label="" width="50">
       <template #default="scope">
        <el-button type="danger" :icon="Delete" circle @click="deleteGrafik(scope.row.grafik_id,scope.$index)" />
      </template>
    </el-table-column>
    
    
  </el-table>

  </el-col>
  </el-row>
 
</template>
<script  setup>
import { reactive,ref } from 'vue'
import axios from 'axios'
import {Path} from '../config/config'
import { useRouter } from "vue-router";
import { onBeforeMount } from 'vue'
import {
  
  Delete,
 
} from '@element-plus/icons-vue'

let options=[{}];
let results_count=1;
let edit = false;
let editid=0;
const data=reactive({
  data: [],
  data2: [],
})
const value2 = ref([]);
const router =useRouter();
onBeforeMount( ()=>{
   if(!sessionStorage.username){
     router.push({path: `/Login`});
  }
  loadData();
   loadData2();
})

function AddResult(){
  form.results.push({id:++results_count});
  console.log(form.results);
}

async function loadData(){
  
  await axios.get(`${Path}/getgrafik.php`)
  .then((response)=> {
   
    console.log(response);
    data.data2=response.data;
    console.log(data);
   
  })
}
async function loadData2(){
await axios.get(`${Path}/kolektiv.php`)
  .then((response)=> {
   
    console.log(response);
    data.data=response.data;
    console.log(data);
    
    data.data.forEach(element => {
      options.push({label: element.name, value: element.pearson_id});
    });
  })
  options.splice(0,1);
}
const clean = () => {
  form.activity="";
  form.deadline="";
  value2.value=[];
  form.results=[{id:1,value:''}];
  editid=0;
  edit = false;

}
const editGrafik = (id,index) => {
  form.activity=data.data2[index].activity;
  form.deadline=data.data2[index].deadline;
  value2.value=[];
  let formData = new FormData();
   formData.append('id', id);
  axios.post(`${Path}/getgrafikkolektiv.php`,formData)
  .then((response)=> {
    let data=response.data;
   
    data.forEach(element => {
      
      value2.value.push(element[1]);
    });
   
  });
   axios.post(`${Path}/getgrafikresult.php`,formData)
  .then((response)=> {
    let data=response.data;
     console.log(data);
    form.results=[];
    data.forEach(element => {
      formData.append('id', element[0]);
       axios.post(`${Path}/getresult.php`,formData)
  .then((response)=> { 
    console.log(response.data);
   response.data.forEach(element => {
     form.results.push({id:element[0],value:element[1]})
   });
    
    

  });
    });
   
  });
  editid=id;
  edit = true;

}
const deleteGrafik = (id,index) => {
  console.log(id);
  console.log(index);
  let formData = new FormData();
   formData.append('id', id);
  
 
   axios.post(`${Path}/deletegrafik.php`,formData)
  .then((response)=> {
    
    console.log(response);
    
  
    
   
  });
 data.data2.splice(index, 1);
}



//const data=reactive({
//  wrongPass: false,
//})
// do not use same name with ref
const form = reactive({
  activity: '',
  deadline:'',
  results:[{id:1,value:''}],
 
})

const onSubmit = () => {

   let formData = new FormData();
   formData.append('id', editid);
   formData.append('activity', form.activity);
   formData.append('deadline', form.deadline);
   formData.append('kolektiv', JSON.stringify(value2.value));
   formData.append('results', JSON.stringify(form.results));

   if(edit == false){
   axios.post(`${Path}/addgrafik.php`,formData)
  .then((response)=> {
    
    console.log(response);
    
   loadData();
    
   
  });
 }else{
   console.log(form.results);
   axios.post(`${Path}/updategrafik.php`,formData)
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
