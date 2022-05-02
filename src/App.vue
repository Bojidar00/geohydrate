<template>
<div class="header">
<el-row :gutter="0">
    <el-col :span="4">
    <img src="./assets/bas_logo.jpg"/>
    </el-col>
    <el-col :span="4">
    <img src="./assets/logo_io_bas.png"/>
    </el-col>
    <el-col :span="4">
    <img src="./assets/logo_bas_150.png"/>
    </el-col>
     <el-col :span="4">
    <img src="./assets/logo_fni_trans.png"/>
    </el-col>
     <el-col :span="8">
    <el-button type="primary" round @click="handleSelect('6')" color="#145ca4" id="login">Вход</el-button>
    </el-col>
  </el-row>
  </div>
  <el-menu
    
    class="el-menu-demo"
    mode="horizontal"
    background-color="#145ca4"
    text-color="#fff"
    active-text-color="#ffd04b"
    collapse-transition="false"
    @select="handleSelect"
   
  >
    <el-menu-item index="1">Начало</el-menu-item>
    <el-menu-item index="2">За газовите хидрати</el-menu-item>
    <el-menu-item index="3">Колектив</el-menu-item>
    <el-menu-item index="4">График</el-menu-item>
    <el-menu-item index="7">Библиотека</el-menu-item>
    
    
  </el-menu>
 <el-row :gutter="10">
    <el-col :span="20"><router-view/></el-col>
    <el-col :span="4">
    <h1>Новини</h1>
    <table>
    <tr v-for="news in newsdata" :key="news.news_id">
      <News :title="news.title" :id="Number(news.news_id)" :img="news.pic"/>
    </tr>
    </table>
    </el-col>
  </el-row>



  
</template>
<script  >
import router from './router';
import News from './components/News.vue';
import axios from 'axios'
import {Path} from './config/config'
export default {
  components: {
   News
  },
  data(){
    return {
      newsdata:[],
    }
  },
  created(){
    this.loadNews();
  },
  methods:{



 handleSelect(payload) { 
  switch(payload){
    case '1':  router.push({ path: '/' }); break; 
    case '2':  router.push({ path: '/About'}); break;
    case '3':  router.push({ path: '/Kolektiv'}); break;
    case '4':  router.push({ path: '/Grafik'}); break;
    case '6':  router.push({ path: '/Login'}); break;
    case '7':  router.push({ path: '/library'}); break;

   
    
  }
},
loadNews(){
   axios.get(`${Path}/lastnews.php`)
  .then((response)=> {
   this.newsdata=response.data;
    console.log(response);
  })
}

  }
}
</script>
<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;
}

#nav a {
  font-weight: bold;
  color: #2c3e50;
  
}
a {
    text-decoration: none;
}
#nav a.router-link-exact-active {
  color: #42b983;
}
.header{
  height: 50px;
  padding-bottom: 5px;
}
img{
  max-height:40%;

}
.el-row {
  margin: 20px;
}
#login{
  float:right !important; 
}

</style>
