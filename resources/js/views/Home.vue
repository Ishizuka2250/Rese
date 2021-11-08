<template>
  <div class="container">
    <div class="login-user">
      {{user}}さん
    </div>
    <div class="main-containts">
      <div class="reserves">
        <h2 class="content-title">予約状況</h2>
        <div class="list">
          <div v-for="reserve, index in reserves" :key="index" class="reserve-card">
            <div class="reserve-card-header">
              <div class="reserve-name">
                <img :src="'/images/clock.png'" alt="" class="reserve-card-img">
                <p>予約1</p>
              </div>
              <img :src="'/images/cancel.png'" class="reserve-card-img" alt="">
            </div>
            <table class="reserve-detail">
              <tr>
                <th>Shop</th>
                <td>{{reserve.restaulant_id}}</td>
              </tr>
              <tr>
                <th>Date</th>
                <td>{{reserve.reserve_date | getDate}}</td>
              </tr>
              <tr>
                <th>Time</th>
                <td>{{reserve.reserve_date | getTime}}</td>
              </tr>
              <tr>
                <th>Number</th>
                <td>1人</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="favorites">
        <h2 class="content-title">お気に入り店舗</h2>
        <div class="list">
          <div class="favorite-card">
            <div class="favorite-card-img">
              <img :src="'/shop-images/sushi.jpg'" alt="">
            </div>
            <div class="favorite-card-content">
              <p class="shop-name">仙人</p>
              <div class="shop-genles">
                <p>#東京都</p>
                <p>#寿司</p>
              </div>
              <div class="favorite-card-footer">
                <a href="#" class="shop-detail-button">詳しくみる</a>
                <img :src="'/images/heart.png'" class="heart" alt="">
              </div>
            </div>
          </div>
          <div class="favorite-card">
            <div class="favorite-card-img">
              <img :src="'/shop-images/sushi.jpg'" alt="">
            </div>
            <div class="favorite-card-content">
              <p class="shop-name">仙人</p>
              <div class="shop-genles">
                <p>#東京都</p>
                <p>#寿司</p>
              </div>
              <div class="favorite-card-footer">
                <a href="#" class="shop-detail-button">詳しくみる</a>
                <img :src="'/images/heart.png'" class="heart" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
export default {
  data() {
    return {
      id: this.userinfo.id,
      user: this.userinfo.name,
      reserves: []
    }
  },
  async mounted() {
    const response = await axios.get(
      "http://localhost:8000/api/v1/reserves/" + this.id
    );
    this.reserves = response.data.reserves;
    console.log(response);
  },
  filters: {
    getTime(value) {
      return moment(value).format("kk:mm");
    },
    getDate(value) {
      return moment(value).format("YYYY/MM/DD");
    }
  },
  props: ['userinfo']
}
</script>

<style scoped>
.container {
  margin: 0 80px 80px 80px;
}
.login-user {
  font-size: 30px;
  font-weight: bold;
  margin: 30px 0;
}
.main-containts {
  display: flex;
  justify-content: space-between;
}
.content-title {
  display: block;
  font-size: 26px;
  margin: 20px 0;
}
.reserves {
  width: 35%;
  display: flex;
  flex-direction: column;
}
.favorites {
  width: 60%;
}
.list {
  display: flex;
  justify-content: space-between;
}
.favorite-card {
  width: 300px;
  border-radius: 5px;
  box-shadow: 0 0 5px #000;
  overflow: hidden;
}
.favorite-card-img {
  height: 160px;
}
.favorite-card-img img{
  width: 100%;
  height: inherit;
  object-fit: cover;
}
.favorite-card-content {
  padding: 20px;
}
.shop-name {
  font-weight: bold;
  margin-bottom: 10px;
  font-size: larger;
}
.shop-genles {
  display: flex;
  margin-bottom: 20px;
}
.shop-genles p:not(:last-of-type) {
  display: inline-block;
  margin-right: 10px;
}
.shop-detail-button {
  display: inline-block;
  text-decoration: none;
  color: #FFF;
  background-color: #305dff;
  padding: 10px 20px;
  border-radius: 5px;
}
.favorite-card-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.heart {
  display: inline-block;
  width: 30px;
  height: 30px;
}
.reserve-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 10px;
}
.reserve-card {
  width: 100%;
  padding: 25px;
  border-radius: 5px;
  background: #305dff;
  box-shadow: 0 0 5px #000;
}
.reserve-card-img {
  width: 25px;
}
.reserve-name {
  display: flex;
  align-items: center;
}
.reserve-name p {
  display: inline-block;
  margin-left: 30px;
  color: #FFF;
}
.reserve-detail {
  margin-top: 40px;
}
.reserve-detail tr th {
  text-align: left;
  padding-right: 20px;
  padding-bottom: 20px;
  color: #FFF;
}
.reserve-detail tr td {
  color: #FFF;
}
</style>