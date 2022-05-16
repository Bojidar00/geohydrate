<template>
<div class="header">
<el-row :gutter="0">
 <el-col :span="1" :xs="0">
   </el-col>
     <el-col :span="5" >
     <a href="https://www.fni.bg/">
    <img src="./assets/logo_fni_trans.png" class="imgleft"/>
    </a>
    </el-col>
     <el-col :span="5" >
     <a href="http://io-bas.bg/">
    <img src="./assets/logo_io_bas.png" class="imgleft"/>
    </a>
    </el-col>
    <el-col :span="4">
    <a href="https://www.bas.bg/">
    <img src="./assets/logo_bas_150.png" class="imgleft"/>
    </a>
    </el-col>
   <el-col :span="5" :xs="3">
   </el-col>
    
    
    <el-col :span="2" :xs="3">
    <img src="./assets/Flag_UK-BG.png" class="sml" @click="lang" />
    </el-col>
     <el-col :span="2" :xs="4">
    <el-button type="primary" round @click="handleSelect('6')" color="#145ca4" id="login" class="bright">Вход</el-button>
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
    <el-menu-item index="1">{{home}}</el-menu-item>
    <el-menu-item index="2">{{about}}</el-menu-item>
    <el-menu-item index="3">{{team}}</el-menu-item>
    <el-menu-item index="4">{{schedule}}</el-menu-item>
    <el-menu-item index="7">{{library}}</el-menu-item>
    
    
  </el-menu>
  <div class="StickyContent">
    <el-row :gutter="10">
    <el-col :span="21">
<div class="text">Проект ГЕОХидрат: Геотермична еволюция на морски находища на газови хидрати в палеоделтата на Дунав, Черно море.<br>
Договор на Фонд „Научни изследвания“ и Институт по Океанология - БАН КП-06-ОПР04/7 от 18.12.2018 г.</div>
</el-col>
</el-row>
 <el-row :gutter="10">
    <el-col :span="1"></el-col>
    <el-col :span="19"><router-view/></el-col>
    <el-col :span="1"></el-col>
    <el-col :span="3">
    <h1>{{news}}</h1>
    <table>
    <tr v-for="news in newsdata" :key="news.news_id">
      <News :title="news.title" :id="Number(news.news_id)" :img="news.pic"/>
    </tr>
    </table>
    </el-col>
  </el-row>
</div>
 <Waves class="StickyFooter"></Waves>

 
</template>
<script  >
import router from './router';
import News from './components/News.vue';
import Waves from './components/Waves.vue';
import axios from 'axios'
import {Path} from './config/config'
export default {
  components: {
   News,
   Waves
  },
  data(){
    return {
      newsdata:[],
      home:'Начало',
      about:'За газовите хидрати',
      team:'Колектив',
      schedule:'График',
      library:'Библиотека',
      news:'Новини',
    }
  },
  created(){
    this.loadNews();
    this.changeLang();
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
    
  })
},
changeLang(){
  if(sessionStorage.lang){
    if(sessionStorage.lang==="en"){
      this.home="Home";
      this.about="About";
      this.team="Team";
      this.schedule="Schedule";
      this.library="Library";
      this.news="News";
    }
  }
},
lang(){
  if(sessionStorage.lang){
    if(sessionStorage.lang==="bg"){
      sessionStorage.lang="en";
    }else{
      sessionStorage.lang="bg";
    }
  }else{
  sessionStorage.lang="bg";}
  router.go();
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
.sml{
  width: 30px;
  float:left;
}





.StickyFooter {
 
   flex: 0 0 auto !important;
   bottom: 0;
}


.StickyContent {
 flex: 1 1 auto !important;
  
}
body {
  height:100%;
  min-height:100%;
  overflow: hidden;
}
html,body {
  height:95%;
  min-height:95%;
  overflow-y: scroll;
  overflow-x: hidden;
  
}

::-webkit-scrollbar{display:none;}



.imgleft{
  float:left;
  max-width:100%;

}
.bright{
  float: right;
  max-width:100%;
}

.text{
  color: #145ca4;
}
</style>
