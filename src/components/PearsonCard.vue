<template>
  <el-card class="box-card">
    <table>
        <tr><td ></td><td><b>{{data.name}}</b></td></tr>
        <tr><td align="right" class="left">Месторабота:</td><td align="left" class="right">{{data.job_location}}</td></tr>
        <tr><td align="right" class="left">Образование:</td><td align="left" class="right">{{data.education}}</td></tr>
        <tr><td align="right" class="left">Длъжност, последни 5 години:</td><td align="left" class="right">{{data.last_job}}</td></tr>
        <tr><td align="right" class="left">Област на работа:</td><td align="left" class="right">{{data.job}}</td></tr>
        <tr><td align="right" class="left">За контакт:</td><td align="left" class="right">{{data.email}}</td></tr>
    </table>
  </el-card>
</template>
<script >
export default {
  name: 'PearsonCard',
  props: {
    data: {},
    
  },
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

</style>


