<template>
  <el-card class="box-card center width" @click="op()">
      <table  >
    <tr><td class="td">{{lname}}:</td><td class="td2">{{name}}</td></tr>
   <tr><td class="td">{{ldescription}}:</td><td class="td2"> {{description}}</td></tr>
    </table>
    <el-button type="primary" round @click="op()" color="#145ca4" >{{lopen}}</el-button>
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
   description:{
    type: String,
    default: ''
  },
    path:{
    type: String,
    default: ''
  },
   
  },
   data(){
      return{
        lname:'Име',
        ldescription:'Описание',
        lopen:'Отвори',
      }
    },
    mounted(){
      this.changeLang();
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
    },
    changeLang(){
  if(sessionStorage.lang){
    if(sessionStorage.lang==="en"){
      this.lname="Name";
      this.ldescription="Description";
      this.lopen="Open";
      
    }
  }
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

.td{
 
  vertical-align: top;
  font-weight: bold;
  text-align: right;
}
.td2{
  width: 100%;
  text-align: justify;
}
</style>


