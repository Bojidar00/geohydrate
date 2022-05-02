<template>
  <el-card class="box-card center width" @click="op()">
      <table class="center" >
    <tr><td>{{name}}</td></tr>
   <tr><td> <iframe :src="getfileUrl()" ></iframe></td></tr>
    </table>
  </el-card>
</template>
<script >
import {Path} from '../config/config'
export default {
  name: 'LibraryElement',
  props: {
    name:{
    type: String,
    default: ''
  },
    path:{
    type: String,
    default: ''
  },
    
  },
  methods:{
      getfileUrl(){
       var src = Path+'/getfile.php?path='+ this.path;
      //var images = require.context('../../public/images', false)
    //return images('./' + this.data.pic)
    return src;
    },
    op(){
        window.open(this.getfileUrl());
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
.center {
  margin-left: auto;
  margin-right: auto;
}
.width{
    width: 80%;
}
</style>


