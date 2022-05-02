<template>
  <div class="about">
    <h1>{{data.title}}</h1>
    <img :src="getImgUrl()"
          
          class="image"
          
        />
        <div>
          {{data.content}}
        </div>
  </div>


</template>
<script>
import axios from 'axios'
import {Path} from '../config/config'





export default {
  name: 'NewsPage',
  components: {
   
  },
  data(){
    return {
     data:[]
    }
  },
  created(){
    this.loadNews();
  },
  watch: {
    '$route.path': 'loadNews'
  },
  methods:{
    test(){
     
      var Index = require('../../public/otchet_e1.pdf');
      window.open(Index);
    },

    loadNews(){

      console.log(this.$route.params.id);
      axios.get(`${Path}/news.php?id=${this.$route.params.id}`)
  .then((response)=> {
    // handle success
    this.data=response.data;
    
  })
  .catch(function (error) {
    // handle error
    console.log(error);
  })

    },
     getImgUrl(){
       var src = Path+'/getfile.php?path='+this.data.pic;
      //var images = require.context('../../public/images', false)
    //return images('./' + this.data.pic)
    return src;
    }
  }
 
 
}


</script>