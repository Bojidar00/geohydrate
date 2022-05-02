<template>
  <el-menu
    
    class="el-menu-demo"
    mode="horizontal"
    background-color="#f78c00"
    text-color="#fff"
    active-text-color="#ffd04b"
    collapse-transition="false"
    @select="handleSelect"
   
  >
    <el-menu-item index="1">Данни</el-menu-item>
    <el-menu-item index="2">Добави новина</el-menu-item>
    <el-menu-item index="3">Добави Колектив</el-menu-item>
    <el-menu-item index="4">Добави График</el-menu-item>
    <el-menu-item index="5" v-if="show">Добави Администратор</el-menu-item>
    <el-menu-item index="6" >Съдържание</el-menu-item>
    
    
    
  </el-menu>
 
<router-view/>

  
</template>
<script  >
import router from '../router';



export default {
  components: {
  
  },
  
  data(){
    return {
      newsdata:[],
      show:false,
      
    }
  },
  
  mounted(){
     if(!sessionStorage.username){
     router.push({path: `/Login`});
  }
   if(Number(sessionStorage.access)===1){
     this.show=true;
   }
  },
  methods:{



 handleSelect(payload) { 
  switch(payload){
    case '1':  router.push({ path: '/AdminPanel/AddData' }); break; 
    case '2':  router.push({ path: '/AdminPanel/AddNews'}); break;
    case '3':  router.push({ path: '/AdminPanel/AddKolektiv'}); break;
    case '4':  router.push({ path: '/AdminPanel/AddGrafik'}); break;
    case '5':  router.push({ path: '/AdminPanel/AddUser'}); break;
    case '6':  router.push({ path: '/AdminPanel/Content'}); break;
    
    
   
    
  }
},


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
