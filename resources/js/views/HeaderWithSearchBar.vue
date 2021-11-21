<template>
  <header class="header">
    <div class="header-content">
      <div class="header-main">
        <img v-bind:src="'/images/header_img.png'" class="header-menu" alt="" id="header-open">
        <h1 class="header-title">Rese</h1>
      </div>
      <div class="search-bars">
      <v-select :options="this.areas" v-model="area" class="search-bar combo"></v-select>
      <v-select :options="this.genles" v-model="genle" class="search-bar combo"></v-select>
      <input type="text" v-model="search" class="search-bar combo" placeholder="Search Restaurant..">
      <img v-bind:src="'/images/glass.png'" @click="send" class="glass">
      </div>
    </div>
    <div class="menu" id="menu">
      <div class="menu-contents">
        <img v-bind:src="'/images/close_img.png'" class="header-menu" alt="" id="header-close">
        <nav>
          <a href="/app/home">MyPage</a>
          <a href="/app/restaurant">Restaurant</a>
          <a v-pre href="/login" style="text-decoration: none" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            Logout
          </a>
          <form id="logout-form" action="/logout" method="POST">
            <input type="hidden" name="_token" :value="this.csrf">
          </form>
        </nav>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  data () {
    return {
      area: 'All Area',
      genle: 'All Genle',
      search: '',
      areas: ['All Area', '東京都'],
      genles: ['All Genle', '寿司'],
    }
  },
  mounted() {
    const headerOpen = document.getElementById("header-open");
    headerOpen.addEventListener('click', () => {
      const menu = document.getElementById("menu");
      menu.classList.toggle('show');
    });

    const headerClose = document.getElementById("header-close");
    headerClose.addEventListener('click',() => {
      const menu = document.getElementById("menu");
      menu.classList.toggle('show');
    });
  },
  methods: {
    send() {
      const sendArea = this.area == null ? 'All Area' : this.area;
      const sendGenle = this.genle == null ? 'All Genle' : this.genle;
      this.$emit('send-search', {
        area: sendArea,
        genle: sendGenle,
        search: this.search
      });
    }
  },
  props: ["csrf"]
}
</script>

<style scoped>
.search-bars {
  display: flex;
  align-items: center;
}
.search-bars div {
  width: 180px;
  display: inline-block;
}
.search-bars input {
  width: 250px;
  padding: 7px;
  font-size: 16px;
  border: 1px solid rgba(60, 60, 60, .26);
  border-radius: 3px;
}
.glass {
  width: 30px;
  padding: 2px;
}
.glass:hover {
  cursor: pointer;
}
.header{
  margin: 50px 0 50px 0px;
}
.header-content {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.header-main {
  display: inline-block;
}
.header-menu {
  display: inline-block;
  width: 50px;
  border-radius: 5px;
  box-shadow: 2px 2px 5px #000;
}
.header-menu:hover {
  cursor: pointer;
}
.header-title {
  display: inline-block;
  font-size: 50px;
  margin-left: 40px;
  color: #305dff;
}
.menu {
  position: absolute;
  width: 250px;
  height: 100vh;
  top: 0;
  left: -252px;
  transition: 0.5s;
  border-right: 2px solid #000;
  background: #fff;
}
.show {
  transform: translateX(252px);
}
.menu-contents img {
  margin-left: 100px;
  margin-top: 50px;
  margin-bottom: 30px;
}
.menu-contents nav {
  display: flex;
  flex-direction: column;
  align-items: center;
}
.menu-contents nav a {
  display: inline-block;
  text-decoration: none;
  font-size: large;
}
.menu-contents nav a:not(:last-child) {
  margin-bottom: 20px;
}
</style>

