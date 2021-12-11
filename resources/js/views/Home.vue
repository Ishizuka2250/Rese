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
                v-on:click="removeReserve(reserve.id)">
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
          <div v-if="reservesEmpty" id="reserve-empty" class="empty">
            現在ご予約はありません。
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
                <a v-bind:href="'/app/restaurant/' + favorite.restaurant_id + '/detail'" class="shop-detail-button">詳しくみる</a>
                <img v-bind:src="'/images/heart_red.png'" v-on:click="removeFavorite(favorite.id)" class="heart" alt="">
              </div>
            </div>
          </div>
          <div v-if="favoritesEmpty" id="favorite-empty" class="empty">
            現在お気に入りは登録されていません。
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
      reservesEmpty: false,
      favorites: [],
      favoritesEmpty: false,
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
    showEmpty() {
      document.getElementById('reserve-empty').classList.remove('hidden')
      document.getElementById('favorite-empty').classList.remove('hidden');
    },
    async removeFavorite(FavoriteID) {
      if (window.confirm('お気に入りから削除しますか？')) {
        await this.callAPIDeleteFavorite(FavoriteID);
        await this.callAPIGetFavorite();
      }
    },
    async removeReserve(ReserveID) {
      if (window.confirm('予約を削除しますか？')) {
        await this.callAPIDeleteReserve(ReserveID);
        await this.callAPIGetReserve();
      }
    },
    async callAPIGetReserve() {
      const reservesResponse = await axios.get(
        "/api/v1/reserves?userid=" + this.id
      );
    this.reserves = reservesResponse.data.reserves;
    this.reservesEmpty = this.reserves.length == 0 ? true : false;
    },
    async callAPIGetFavorite() {
      const favoritesResponse = await axios.get(
        "/api/v1/favorites?user_id=" + this.id
      );
      this.$set(this.favorites, favoritesResponse.data.favorites);
      this.favoritesEmpty = this.favorites.length == 0 ? true : false;
    },
    async callAPIDeleteReserve(ReserveID) {
      await axios.request({
        method: 'delete',
        url: '/api/v1/reserves/delete',
        data: {reserve_id: ReserveID}
      }).then(function(response) {
        alert(response.data.message);
      }).catch(function(error) {
        alert(error);
      });
    },
    async callAPIDeleteFavorite(FavoriteID) {
      axios.request({
        method: 'delete',
        url: '/api/v1/favorites/delete',
        data: {favorite_id: FavoriteID}
      }).then(
        function (response) {
          if (response.data.errorcode) alert(response.data.message);
        }
      ).catch(
        function (error) {
          alert(error);
        }
      );
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
.hidden {
  display: none;
}
.empty {
  color: #000;
  width: 90%;
  padding: 25px;
  border-radius: 5px;
  height: 150px;
  box-shadow: 0 0 5px #000;
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
.heart:hover {
  cursor: pointer;
}

</style>