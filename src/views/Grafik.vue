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
    <el-table-column label="Дейности" prop="activity" />
    <el-table-column label="Срок в месеци" prop="deadline" />
  </el-table>
</template>
<script  setup>
import axios from 'axios'
import {Path} from '../config/config'
import { onBeforeMount } from 'vue'
import {reactive } from 'vue'
//import { result } from 'lodash';
const data=reactive({
  data: [],});
onBeforeMount( ()=>{
  loadData();
   
})
async function loadData(){
 
   await axios.get(`${Path}/getallgrafik.php`)
  .then((response)=> {
   
    console.log(response);
    //let cid=0;
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
  /* data.forEach(element => {
     tableData2.push(element);
   }); */
    
   console.log(data.data);
  // console.log(data);
  })
   console.log(data.data);
   //data.data.push({activity:'',deadline:'',contractors:[],results:[]});
   
}

/*let tableData2 = [{activity: " РП.1 - Анализ на информация",deadline:"до 30.VI.2019, 6 м.",contractors:["	доц. д-р Атанас Василев","доц. д-р Орлин Димитров","доц. д-р Иван Генов","доц. д-р Димитър Димитров","инж. Петър Пецински","доц. д-р Никола Ботушаров","д-р Данаил Йовчев","Росица Пехливанова, магистър"],results:["База данни ГЕОХидрат.","Обучение/обработка на сеизмични записи - Schlumberger Petrel; 3D ГХН.","Входни данни на многопараметричен симулационен модел – Schlumberger PetroMod.","Детайлна програма и график на Проекта."] },
{activity:"РП.2 - Изследвания",deadline:"до 31.III.2020, 9 м.",contractors:["доц. д-р Атанас Василев","доц. д-р Иван Генов","доц. д-р Никола Ботушаров","д-р Данаил Йовчев"],results:["Оценка на влиянието на физическите параметри на аномалиите на температурата и топлинния поток при формиране на ГХН; таблици, графики и карти.","4D модел на ГХН и измеримите аномалии на температурата и топлинния поток; псевдо 3D изображения."]},
{activity:" РП.3 - Права задача, публикации",deadline:"до 30.VI.2020, 3 м.",contractors:["	доц. д-р Атанас Василев","доц. д-р Орлин Димитров","доц. д-р Иван Генов","доц. д-р Димитър Димитров","инж. Петър Пецински","доц. д-р Никола Ботушаров","д-р Данаил Йовчев","Росица Пехливанова, магистър"],results:["Методи за определяне на аномалиите на температурата и топлинния поток.","Анализ на D1-D2 резултати, ресурсна оценка; GIS карти, разрези."," Обратна геотермична задача: теория и софтуер (списъци, таблици).","Отчет за Етап 1 на проекта."]}];
*/
</script>