<template>
  <div class="container">
    <appHeader :csrf="this.csrf"></appHeader>
    <div class="app-body">
      <div class="restaurant-detail two-container">
        <div class="detail-header">
          <div class="prev-button">＜</div>
          <h2 class="restaurant-name">仙人</h2>
        </div>
        <img v-bind:src="'/shop-images/sushi.jpg'" alt="">
        <p class="shop-area-genles">#東京都 #寿司</p>
        <p class="shop-detail">料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。食材・味・価格、お客様の満足度を徹底的に追及したお店です。特別な日のお食事、ビジネス接待まで気軽に使用することができます。</p>
      </div>
      <div class="reserve-detail two-container">
        <h2>予約</h2>
        <input type="date">
        <input type="text">
        <input type="text">
        <div class="reserve-check">
          <table class="reserve-check-detail">
            <tr>
              <th>Shop</th>
              <td>仙人</td>
            </tr>
            <tr>
              <th>Date</th>
              <td>2021-04-01</td>
            </tr>
            <tr>
              <th>Time</th>
              <td>17:00</td>
            </tr>
            <tr>
              <th>Number</th>
              <td>1人</td>
            </tr>
          </table>
        </div>
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
  width: 45%;
}
.restaurant-detail {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
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
}
.reserve-detail {
  background: #305dff;
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