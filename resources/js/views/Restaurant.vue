<template>
  <div class="container">
    <appHeader :csrf="this.csrf"></appHeader>
    <div class="main-containts">
      <div class="reserves">
        <p>hoge</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
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
      favorites: [],
    }
  },
  async mounted() {
    // const reservesResponse = await axios.get(
    //   "http://localhost:8000/api/v1/reserves/" + this.id
    // );
    // this.reserves = reservesResponse.data.reserves;
    // const favoritesResponse = await axios.get(
    //   "http://localhost:8000/api/v1/favorites/" + this.id
    // );
    // this.favorites = favoritesResponse.data.favorites;
  },
  filters: {
    getTime(value) {
      return moment(value).format("kk:mm");
    },
    getDate(value) {
      return moment(value).format("YYYY/MM/DD");
    },
    getImageName(value) {
      let imageName = "000" + value;
      return "/shop-images/" + imageName.slice(-3) + ".jpg";
    },
  },
  methods: {
    getGenle(value) {
      return value.split(",")
    }
  },
  props: ["userinfo", "csrf"]
}
</script>

<style scoped>
.container {
  margin: 0 80px 80px 80px;
}
.main-containts {
  display: flex;
}

</style>