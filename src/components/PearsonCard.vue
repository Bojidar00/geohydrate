<template>
  <el-card class="box-card">
     
    <table>
      <tr><img :src="getImgUrl()"  class="img"
        /> </tr>
        <tr><td ></td><td><b>{{data.name}}</b></td></tr>
        <tr><td align="right" class="left">Организация:</td><td align="left" class="right">{{data.job_location}}</td></tr>
        <tr><td align="right" class="left">Образование:</td><td align="left" class="right">{{data.education}}</td></tr>
        <tr><td align="right" class="left">Длъжност:</td><td align="left" class="right">{{data.last_job}}</td></tr>
        <tr><td align="right" class="left">Научна област:</td><td align="left" class="right">{{data.job}}</td></tr>
        <tr><td align="right" class="left">За контакт:</td><td align="left" class="right">{{data.email}}</td></tr>
    </table>
  </el-card>
</template>
<script >
import {Path} from '../config/config'
export default {
  name: 'PearsonCard',
  props: {
    data: {},
    
  },methods:{
     getImgUrl(){
       var src = Path+'/getfile.php?path='+this.data.pic;
   
    return src;
    }
  }
}
</script>

<style>
.left{
    
     white-space: nowrap;
     padding-right:5px ;
     padding-bottom: 20px;
}
.right{
    float: left;
    padding-bottom: 20px;
}

.img{
  max-width: 200px;
}

</style>


