<template>
  


<table v-for="file in files" :key="file.file_id" class="table">
<tr><library-element :name="file.name" :description="file.description" :path="file.path"></library-element></tr>
</table>

<el-pagination background layout="prev, pager, next" :total="tot" :page-size="10"   @current-change="show" />

</template>
<script>
import axios from 'axios'
import {Path} from '../config/config'
import LibraryElement from '../components/LibraryElement.vue'





export default {
  name: 'library',
  components: {
   LibraryElement
  },
  data(){
    return {
     page:1,
     tot:0,
     files:[],
     
    }
  },
  mounted(){
this.loadCount();
this.loadFiles();


  },
  methods:{
    test(){
     
      var Index = require('../../public/otchet_e1.pdf');
      window.open(Index);
    },
 
    test2(){
      axios.get(`${Path}/kolektiv.php`)
  .then(function (response) {
    // handle success
    console.log(response);
  })
  .catch(function (error) {
    // handle error
    console.log(error);
  })
    },
    getfileUrl(){
       var src = Path+'/getfile.php?path='+ 'uploads/otchet_e1.pdf';
      //var images = require.context('../../public/images', false)
    //return images('./' + this.data.pic)
    return src;
    },
    show(a){
      this.page=a;
      this.loadFiles();
    },
   async loadCount(){
      await axios.get(`${Path}/getfilecount.php`)
  .then((response)=> {
    this.tot=Number(response.data[0].count);
    
    
  })  
 
    },
     async loadFiles(){
        let formData = new FormData();
        formData.append('offset', ((this.page-1)*10));
      await axios.post(`${Path}/getfiles.php`,formData)
  .then((response)=> {
   
   
    this.files=response.data;
    
  })
    }
  }

 
 
}


</script>
<style>

.table{
  width: 100%;
}
</style>