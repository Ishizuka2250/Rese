<template>
  <div class="container">
    <appHeader :csrf="this.csrf"></appHeader>
    <div class="login-user">
      {{user}}さん
    </div>
    <div class="main-containts">
      <div class="reserves">
        <h2 class="content-title">予約状況</h2>
        <div class="list flex-column">
          <div v-for="reserve, index in reserves" :key="index" class="reserve-card">
            <div class="reserve-card-header">
              <div class="reserve-name">
                <img v-bind:src="'/images/clock.png'" alt="" class="reserve-card-img">
                <p>予約{{(index + 1)}}</p>
              </div>
              <img v-bind:src="'/images/cancel.png'" alt="" class="reserve-card-img"
                v-on:click="callAPIDeleteReserve(reserve.id)">
            </div>
            <table class="reserve-detail">
              <tr>
                <th>Shop</th>
                <td>{{reserve.name}}</td>
              </tr>
              <tr>
                <th>Date</th>
                <td>{{reserve.reserve_date}}</td>
              </tr>
              <tr>
                <th>Time</th>
                <td>{{toHourMinuite(reserve.reserve_time)}}</td>
              </tr>
              <tr>
                <th>Number</th>
                <td>{{reserve.number}}人</td>
              </tr>
            </table>
          </div>
        </div>
      </div>
      <div class="favorites">
        <h2 class="content-title">お気に入り店舗</h2>
        <div class="list flex-row">
          <div v-for="favorite, index in favorites" :key="index" class="favorite-card">
            <div class="favorite-card-img">
              <img v-bind:src="'/shop-images/' + favorite.image_file_name" alt="">
            </div>
            <div class="favorite-card-content">
              <p class="shop-name">{{favorite.name}}</p>
              <div class="shop-area-genles">
                <p>#{{favorite.area}}</p>
                <p v-for="genle, index in splitCSV(favorite.genles)" :key="index">#{{genle}}</p>
              </div>
              <div class="favorite-card-footer">
                <a href="#" class="shop-detail-button">詳しくみる</a>
                <img v-bind:src="'/images/heart_red.png'" class="heart" alt="">
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
import header from './Header.vue';
export default {
  components: {
    appHeader: header
  },
  data() {
    return {
      id: this.userinfo.id,
      user: this.userinfo.name,
      reserves: [],
      favorites: []
    }
  },
  mounted() {
    this.callAPIGetReserve();
    this.callAPIGetFavorite();
  },
  methods: {
    splitCSV(value) {
      return value || undefined ? value.split(',') : '';
    },
    toHourMinuite(value) {
      const splitedValue = String(value).split(':');
      return splitedValue[0] + ':' + splitedValue[1];
    },
    async callAPIGetReserve() {
      const reservesResponse = await axios.get(
        "http://localhost:8000/api/v1/reserves/?userid=" + this.id
      );
    this.reserves = reservesResponse.data.reserves;
    },
    async callAPIGetFavorite() {
      const favoritesResponse = await axios.get(
        "http://localhost:8000/api/v1/favorites/" + this.id
      );
      this.favorites = favoritesResponse.data.favorites;
    },
    async callAPIDeleteReserve(ReserveID) {
      if (window.confirm('予約を削除しますか？')) {
        await axios.request({
          method: 'delete',
          url: 'http://localhost:8000/api/v1/reserves/delete',
          data: {reserve_id: ReserveID}
        }).then(function(response) {
          alert(response.data.message);
        }).catch(function(error) {
          alert(error);
        });
        this.callAPIGetReserve();
      }

    }
  },
  props: ["userinfo", "csrf"],
}
</script>

<style scoped>
.container {
  margin: 40px 80px 80px 80px;
}
.login-user {
  font-size: 30px;
  font-weight: bold;
  margin: 30px 0;
}
.main-containts {
  display: flex;
}
.content-title {
  display: block;
  font-size: 26px;
  margin: 20px 0;
}
.reserves {
  width: 400px;
  margin-right: 50px;
}
.favorites {
  width: 60%;
}
.list {
  display: flex;
}
.flex-column {
  flex-direction: column;
}
.flex-column div{
  margin-bottom: 10px;
}
.flex-row {
  flex-direction: row;
  flex-wrap: wrap;
}
.flex-row div {
  margin-right : 10px;
  margin-bottom: 10px;
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
  box-sizing: border-box;
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
.favorite-card {
  width: 300px;
  border-radius: 5px;
  box-shadow: 0 0 5px #000;
  overflow: hidden;
}
.favorite-card-img {
  width: inherit;
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
.shop-area-genles {
  display: flex;
  margin-bottom: 20px;
}
.shop-area-genles p:not(:last-of-type) {
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

</style>