<template>
  <div class="container">
    <appHeader :csrf="this.csrf"></appHeader>
    <div class="app-body">
      <div class="restaurant-detail two-container flex-column">
        <div class="detail-header">
          <a href="/app/restaurant" class="prev-button">＜</a>
          <h2 class="restaurant-name">{{restaurantDetail.name}}</h2>
        </div>
        <img v-if="restaurantDetail.image_file_name" v-bind:src="'/shop-images/' + restaurantDetail.image_file_name" alt="">
        <div class="shop-area-genles">
          <p>#{{restaurantDetail.area}}</p>
          <p v-for="genle, index in splitCSV(restaurantDetail.genles)" :key="index">#{{genle}}</p>
        </div>
        <p class="shop-detail">{{restaurantDetail.detail}}</p>
      </div>
      <div class="reserve-detail two-container flex-column">
        <div class="reserve-detail-input">
          <h2>予約</h2>
          <input class="input date" type="date" v-model="selectReserveDate" v-on:change="callAPIGetReserve('allow')" required>
          <select id="reserveTime" class="input" v-model="selectReserveTime" v-on:change="reservationNumberUpdate()" required>
            <option :value="null" disabled>予約時間を選択してください。</option>
            <option v-for="time, index in getReservationTime()" :key="index" v-bind:value="time">
              {{time}}
            </option>
          </select>
          <select id="reserveNumber" class="input" v-model="selectReserveNumber" required>
            <option :value="null" disabled>予約人数を選択してください。</option>
            <option v-for="num in this.maxReserveNumber" :key="num" v-bind:value="num">{{num}}</option>
          </select>
          <div class="reserve-check">
            <table class="reserve-check-detail">
              <tr>
                <th>Shop</th>
                <td>{{restaurantDetail.name}}</td>
              </tr>
              <tr>
                <th>Date</th>
                <td v-if="this.selectReserveDate">{{this.selectReserveDate}}</td>
                <td v-else></td>
              </tr>
              <tr>
                <th>Time</th>
                <td v-if="this.selectReserveTime">{{this.selectReserveTime}}</td>
                <td v-else></td>
              </tr>
              <tr>
                <th>Number</th>
                <td v-if="this.selectReserveNumber">{{this.selectReserveNumber}}</td>
                <td v-else></td>
              </tr>
            </table>
          </div>
        </div>
        <div class="reserve-button" v-on:click="callAPIPostReserve()">
          予約する
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import header from './Header.vue';
import axios from 'axios';
import moment from 'moment';
export default {
  data() {
    return {
      userid: this.userinfo.id,
      selectReserveDate: '',
      selectReserveTime: '',
      selectReserveNumber: 0,
      maxReserveNumber: 0,
      restaurantDetail: [],
      reservationAllow: []
    }
  },
  components: {
    appHeader: header
  },
  mounted() {
    this.callAPIGetRestaurant('details');
    this.callAPIGetReserve('allow');
  },
  methods: {
    splitCSV(value) {
      return value || undefined ? value.split(',') : '';
    },
    reservationNumberUpdate() {
      Object.keys(this.reservationAllow).forEach(key => {
        if (this.reservationAllow[key].time == this.selectReserveTime) {
          this.maxReserveNumber = this.reservationAllow[key].max_reserve > 5 ? 5 : this.reservationAllow[key].max_reserve;
        }
      })
    },
    async callAPIGetRestaurant(args) {
      const restaurantDetailResponse = await axios.get(
        'http://localhost:8000/api/v1/restaurants/' + args + '?id=' + this.$route.params.id
      );
      this.restaurantDetail = restaurantDetailResponse.data.details[0];
      this.selectReserveDate = moment().format('YYYY-MM-DD');
    },
    async callAPIGetReserve(args) {
      const reservationAllowResponse = await axios.get(
        'http://localhost:8000/api/v1/reserves/' + args + '?restaurantid=' + this.restaurantDetail.id
          + '&date=' + this.selectReserveDate
      );
      this.reservationAllow = reservationAllowResponse.data.allow;
    },
    getReservationTime() {
      const reservationTime = [];
      Object.keys(this.reservationAllow).forEach(key => {
        this.reservationAllow[key].max_reserve > 0 ? reservationTime.push(this.reservationAllow[key].time) : ''
      });
      return reservationTime;
    },
    async callAPIPostReserve() {
      if (this.selectReserveNumber < 1) {
        alert('予約人数が入力されていません.');
        return;
      } else if (this.reserve_time) {
        alert('予約時間を選択してください.');
      }
      axios.post(
        'http://localhost:8000/api/v1/reserves/', {
          user_id: this.userid,
          restaurant_id: this.restaurantDetail.id,
          number: this.selectReserveNumber,
          reserve_date: this.selectReserveDate,
          reserve_time: this.selectReserveTime
          }
      ).then(
        function (response) {
          alert(response.data.message);
        }
      ).catch(
        function(error) {
          console.log(error);
        }
      );
    }
  },
  props: ["userinfo", "csrf"],
}
</script>

<style scoped>
.container {
  width: 100%;
  height: 100vh;
  padding: 40px 80px 80px 80px;
  box-sizing: border-box;
}
.app-body {
  height: calc(100% - 100px);
  display: flex;
  justify-content: space-between;
}
.two-container {
  width: 46%;
}
.flex-column {
  display: flex;
  flex-direction: column;
}
.restaurant-detail > *:not(:last-child) {
  margin-bottom: 20px;
}
.restaurant-detail img {
  width: 100%;
}
.detail-header {
  display: flex;
  align-items: center;
}
.detail-header h2 {
  display: inline-block;
  font-size: 25px;
  margin-left: 20px;
}
.prev-button {
  display: inline-block;
  background: #EEE;
  padding: 10px;
  text-align: center;
  border-radius: 10px;
  box-shadow: 1px 1px 3px #555;
  text-decoration: none;
  font-weight: bold;
}
.prev-button:hover {
  cursor: pointer;
}
.shop-area-genles > p {
  display: inline-block;
}
.shop-area-genles p:not(:last-of-type) {
  margin-right: 10px;
}
.reserve-detail {
  background: #305dff;
  justify-content: space-between;
  border-radius: 10px;
  overflow: hidden;
}
.reserve-detail-input {
  padding: 25px;
  box-sizing: border-box;
}
.reserve-detail-input h2 {
  font-size: 20px;
  margin-bottom: 25px;
  color: #FFF;
}
.input {
  display: block;
  width: 100%;
  padding: 5px 10px;
  margin-bottom: 20px;
  border-radius: 5px;
  border: none;
  font-size: 16px;
}
.date {
  width: 180px;
}
.reserve-check {
  padding: 20px 10px;
  background-color: #4c7eff;
  border-radius: 5px;
}
.reserve-check table tr:not(:last-child) th {
  padding-bottom: 20px;
}
.reserve-check table tr th {
  text-align: left;
  padding-right: 20px;
  color: #FFF;
}
.reserve-button {
  text-align: center;
  background: #0637ff;
  padding: 20px 0;
  color: #FFF;
}
.reserve-button:hover {
  cursor: pointer;
}
.reserve-check table tr td {
  color: #FFF;
}

</style>