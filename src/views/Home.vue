<template>

  
  <el-row :gutter="20" justify="center">
  <el-col :span="20">
  <el-row :gutter="20">
   <el-card :body-style="{ padding: '0px' }">
   <table>
    <tr>
      <td class="td">{{lSummary}}:	</td>
       <td><div v-html="Summary" class="text-left"> </div></td>
      
    </tr>
    </table>
   </el-card>
</el-row>

<el-row :gutter="20">
   <el-card :body-style="{ padding: '0px' }">
   <table>
    <tr>
      <td class="td">{{lPurpose}}:	</td>
      <td><div v-html="Purpose" class="text-left"> </div></td>
    </tr>
    </table>
   </el-card>
   </el-row>
   <el-row :gutter="20">
   <el-card :body-style="{ padding: '0px' }">
   <table>
    <tr>
      <td class="td">{{lMeaning}}:	</td>
      <td><div v-html="Meaning" class="text-left"> </div></td>
       
        
     
    </tr>
    </table>
   </el-card>
   </el-row>

   <el-row :gutter="20">
   <el-card :body-style="{ padding: '0px' }">
   <table>
    <tr>
      <td class="td">{{lChallenges}}:	</td>
      <td><div v-html="Challenges" class="text-left"> </div></td>
      
        
        
     
    </tr>
    </table>
   </el-card>
   </el-row>

   <el-row :gutter="20">
   <el-card :body-style="{ padding: '0px' }">
   <table>
    <tr>
      <td class="td ">{{lScientific}}:</td>
        <td><div v-html="Scientific" class="text-left"> </div></td>
       
        
     
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
     lSummary:'Резюме',
     lPurpose:'Цел',
     lMeaning:'Значение',
     lChallenges:'Предизвикателства',
     lScientific:'Научна област',
    }
  },
  mounted(){
    this.loadData();
    this.changeLang();
  },
  methods:{
   async loadData(){
      await axios.get(`${Path}/getHomedata.php`)
  .then((response)=> {
   
    
    this.Summary=response.data[0].Summary;
    this.Purpose=response.data[0].Purpose;
    this.Meaning=response.data[0].Meaning;
    this.Challenges=response.data[0].Challenges;
    this.Scientific=response.data[0]['Scientific field'];
  })
    },
    changeLang(){
  if(sessionStorage.lang){
    if(sessionStorage.lang==="en"){
      this.lSummary="Summary";
      this.lPurpose="The Aim";
      this.lMeaning="Meaning";
      this.lChallenges="Challenges";
      this.lScientific="Scientific field";
      
    }
  }
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

.text-left{
  text-align: left;
}
.td{
  width:180px ;
  vertical-align: top;
  font-weight: bold;
}

</style>
