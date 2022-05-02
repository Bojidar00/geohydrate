<template>

  
  <el-row :gutter="20" justify="center">
  <el-col :span="20">
  <el-row :gutter="20">
   <el-card :body-style="{ padding: '0px' }">
   <table>
    <tr>
      <td>Резюме:	</td>
       <td><div v-html="Summary"> </div></td>
      
    </tr>
    </table>
   </el-card>
</el-row>

<el-row :gutter="20">
   <el-card :body-style="{ padding: '0px' }">
   <table>
    <tr>
      <td>Цел:	</td>
      <td><div v-html="Purpose"> </div></td>
    </tr>
    </table>
   </el-card>
   </el-row>
   <el-row :gutter="20">
   <el-card :body-style="{ padding: '0px' }">
   <table>
    <tr>
      <td>Значение:	</td>
      <td><div v-html="Meaning"> </div></td>
       
        
     
    </tr>
    </table>
   </el-card>
   </el-row>

   <el-row :gutter="20">
   <el-card :body-style="{ padding: '0px' }">
   <table>
    <tr>
      <td>Предизвикателства:	</td>
      <td><div v-html="Challenges"> </div></td>
      
        
        
     
    </tr>
    </table>
   </el-card>
   </el-row>

   <el-row :gutter="20">
   <el-card :body-style="{ padding: '0px' }">
   <table>
    <tr>
      <td>Научна област:</td>
        <td><div v-html="Scientific"> </div></td>
       
        
     
    </tr>
    </table>
   </el-card>
   </el-row>


   </el-col>
   </el-row>
 
</template>

<script>
// @ is an alias to /src


import axios from 'axios'
import {Path} from '../config/config'



 
export default {
  name: 'Home',
  components: {
    
  },
  data(){
    return {
     Summary:'',
     Purpose:'',
     Meaning:'',
     Challenges:'',
     Scientific:'',

    }
  },
  mounted(){
    this.loadData();
  },
  methods:{
   async loadData(){
      await axios.get(`${Path}/getHomedata.php`)
  .then((response)=> {
   
    console.log(response);
    this.Summary=response.data[0].Summary;
    this.Purpose=response.data[0].Purpose;
    this.Meaning=response.data[0].Meaning;
    this.Challenges=response.data[0].Challenges;
    this.Scientific=response.data[0]['Scientific field'];
  })
    }
  }
}
</script>
<style>
li{
  padding-bottom:10px ;
}
.el-row {
  margin: 20px;
}

.el-card{
  width: 100%;
 
}

</style>
