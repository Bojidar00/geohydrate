<template>
  <el-table :data="data.data" style="width: 100%">
    <el-table-column type="expand">
      <template #default="props">
      <table style="float: left;padding-right: 50px;">
        <tr><b>Изпълнители:</b></tr>
        <ol>
        <li v-for ="i in props.row.contractors" :key="i">{{i}}</li>
        </ol>
      </table>
       <table >
         <tr><b>Резултати:</b></tr>
         <ol>
         <li v-for ="r in props.row.results" :key="r">{{r}}</li>
         </ol>
       </table>
      </template>
    </el-table-column>
    <el-table-column :label="data.activities" prop="activity" />
    <el-table-column :label="data.term" prop="deadline" />
  </el-table>
</template>
<script  setup>
import axios from 'axios'
import {Path} from '../config/config'
import { onBeforeMount } from 'vue'
import {reactive } from 'vue'
//import { result } from 'lodash';
const data=reactive({
  data: [],
  activities:'Дейности',
  term:'Срок в месеци'});
onBeforeMount( ()=>{
  loadData();
   changeLang();
})
function changeLang(){
  if(sessionStorage.lang){
    if(sessionStorage.lang==="en"){
      data.activities="Activities";
      data.term="Term in months";
      
    }
  }
}
async function loadData(){
 
   await axios.get(`${Path}/getallgrafik.php`)
  .then((response)=> {
   
    
    
    let last_result=[];
    let last_pearson=[];
   response.data.forEach(element => {
     if(data.data.length===0){data.data.push({grafik_id:element.grafik_id,activity:element.activity,deadline:element.deadline,contractors:[],results:[]});
     data.data[data.data.length-1].contractors.push(element.name);
     data.data[data.data.length-1].results.push(element.result);
     last_pearson.push(element.pearson_id);
     last_result.push(element.result_id);
     }
     else{
     if(data.data[data.data.length-1].grafik_id!==element.grafik_id){
    data.data.push({grafik_id:element.grafik_id,activity:element.activity,deadline:element.deadline,contractors:[],results:[]});
    last_result=[];
    last_pearson=[];
    }
    if(!last_pearson.includes(element.pearson_id)){
      data.data[data.data.length-1].contractors.push(element.name);
     last_pearson.push(element.pearson_id);
    }

     if(!last_result.includes(element.result_id)){
      data.data[data.data.length-1].results.push(element.result);
      last_result.push(element.result_id);
    }
    }
    
   });
  
    
   

  })
  
  
   
}


</script>