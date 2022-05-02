<template>
  <div class="about">
    
  </div>
  <div class="box" @click="showNews(id)">
  <el-card :body-style="{ padding: '0px' }" >
        <img :src="getImgUrl()"
          
          class="image"
          
        />
        <div style="padding: 14px">
          <span>{{title}}</span>
          <div class="bottom">
           
            <el-button type="text" class="button"></el-button>
          </div>
        </div>
        
      </el-card>
      </div>
</template>
<script>
import {Path} from '../config/config'
export default {
  props: {
    id: Number,
    title: String,
    img: String,
  },
  methods:{
    showNews(id){
      this.$router.push({path: `/News/${id}`});
    },
    getImgUrl(){
      var src = Path+'/getfile.php?path='+this.img;
      //var images = require.context('../../public/images', false)
    //return images('./' + this.img)
    return src;
    }
  }
}
</script>

<style>

.image{
  max-width:100%;
max-height:100%;
}
</style>


