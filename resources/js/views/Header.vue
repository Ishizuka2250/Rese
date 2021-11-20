<template>
  <header class="header">
    <div>
      <img v-bind:src="'/images/header_img.png'" class="header-menu" alt="" id="header-open">
      <h1 class="header-title">Rese</h1>
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
  props: ["csrf"]
}
</script>

<style scoped>
.header{
  display: flex;
  align-items: center;
  margin: 50px 0 50px 0px;
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

