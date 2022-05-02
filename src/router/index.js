import { createRouter, createWebHashHistory } from 'vue-router'
import Home from '../views/Home.vue'
import About from '../views/About.vue'
import Kolektiv from '../views/Kolektiv.vue'
import Grafik from '../views/Grafik.vue'
import Login from '../views/Login.vue'
import NewsPage from '../views/NewsPage.vue'
import AdminPanel from '../views/AdminPanel'
import AddNews from '../views/AddNews'
import AddKolektiv from '../views/AddKolektiv'
import AddGrafik from '../views/AddGrafik'
import AddData from '../views/AddData'
import library from '../views/library'
import AddUser from '../views/AddUser'
import Content from '../views/Content'


const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/About',
    name: 'About',
    component:About
  },
  {
    path: '/Kolektiv',
    name: 'Kolektiv',
    component:Kolektiv
  },
  {
    path: '/Grafik',
    name: 'Grafik',
    component:Grafik
  },
  {
    path: '/library',
    name: 'library',
    component:library
  },
  {
    path: '/Login',
    name: 'Login',
    component:Login
  },
  {
    path: '/News/:id',
    name: 'NewsPage',
    component:NewsPage
  },
  {
    path: '/AdminPanel',
    name: 'AdminPanel',
    component:AdminPanel,
    children: [{
      path: 'Addnews',
      component: AddNews
    },
    {
      path: 'AddKolektiv',
      component: AddKolektiv
    },
    {
      path: 'AddGrafik',
      component: AddGrafik
    },
    {
      path: 'AddData',
      component: AddData
    },
    {
      path: 'AddUser',
      component: AddUser
    },
    {
      path: 'Content',
      component: Content
    }]
    
  },
 
  
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
