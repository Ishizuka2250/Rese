<template>
  <div class="container">
  <header>
    <div class="header-main">
      <img v-bind:src="'/images/header_img.png'" class="header-menu" alt="">
      <h1 class="header-title">Rese</h1>
    </div>
  </header>
    <div class="main-containts">
      <div class="thanks">
        <p class="thanks-message">会員登録ありがとうございます</p>
        <a class="login-button" href="/app/home">ログインする</a>
      </div>
    </div>
  </div>
</template>

<script>
import header from './Header.vue';
export default {
  components: {
    appHeader: header
  },
}
</script>

<style scoped>
.container {
  margin: 40px 80px 80px 80px;
}
.header-main {
  display: flex;
  align-items: center;
  margin-bottom: 50px;
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
.main-containts {
  display: flex;
  justify-content: center;
}
.thanks {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 400px;
  height: 200px;
  background: #FFF;
  padding: 30px;
  border-radius: 5px;
  box-shadow: 2px 2px 5px #000;
}
.thanks-message {
  font-size: 24px;
  margin-bottom: 50px;
}
.login-button {
  text-decoration: none;
  padding: 10px 20px;
  background-color: #305dff;
  border-radius: 5px;
  color: #FFF;
}
</style>
