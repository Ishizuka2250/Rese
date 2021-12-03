<template>
  <div class="container">
    <appHeader :csrf="this.csrf" @send-search="searchRestaurant"></appHeader>
    <div class="restaurants">
      <div class="list flex-row">
        <div v-for="restaurant, index in restaurants" :key="index" class="restaurant-card">
          <div class="restaurant-card-img">
            <img v-bind:src="'/shop-images/' + restaurant.image_file_name" alt="">
          </div>
          <div class="restaurant-card-content">
            <p class="shop-name">{{restaurant.name}}</p>
            <div class="shop-area-genles">
              <p>#{{restaurant.area}}</p>
              <p v-for="genle, index in splitCSV(restaurant.genles)" :key="index">#{{genle}}</p>
            </div>
            <div class="restaurant-card-footer">
              <a v-bind:href="'http://localhost:8000/app/restaurant/' + restaurant.id + '/detail'" class="shop-detail-button">詳しくみる</a>
              <img v-if="isFavorite(restaurant.favorite_id)" :src="'/images/heart_red.png'" class="heart" alt=""
                v-on:click="updateFavorite(userid, index)">
              <img v-else :src="'/images/heart_gray.png'" class="heart" alt=""
                v-on:click="updateFavorite(userid, index)">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import header from './HeaderWithSearchBar.vue';
export default {
  components: {
    appHeader: header
  },
  data() {
    return {
      userid: this.userinfo.id,
      username: this.userinfo.name,
      restaurants: [],
      favorites: []
    }
  },
  mounted() {
    this.callAPIGetRestaurant();
  },
  methods: {
    searchRestaurant(searchItems) {
      this.callAPIGetRestaurant(searchItems);
    },
    splitCSV(value) {
      return value || undefined ? value.split(',') : '';
    },
    isFavorite(FavoriteID) {
      return FavoriteID > 0 ? true : false;
    },
    async callAPIGetRestaurant(params={}) {
      let requestParameter = '?userid=' + this.userid;
      Object.keys(params).forEach(key => {
        requestParameter = params[key] != '' ? requestParameter + '&' + key + '=' + params[key] : requestParameter;
      });
      const restaurantsResponse = await axios.get(
        "http://localhost:8000/api/v1/restaurants/" + requestParameter
      );
      this.restaurants = restaurantsResponse.data.restaurants;
    },
    async getNewFavoriteID(UserID, RestaurantID) {
      await this.callAPIGetFavorite(UserID, RestaurantID);
      return this.favorites[0] || undefined ? this.favorites[0].id : 0;
    },
    async updateFavorite(UserID, Index) {
      if (this.isFavorite(this.restaurants[Index].favorite_id)) {
        await this.callAPIDeleteFavorite(this.restaurants[Index].favorite_id)
        this.restaurants[Index].favorite_id = 0;
      } else {
        this.callAPIPostFavorite(UserID, this.restaurants[Index].id);
        this.restaurants[Index].favorite_id = await this.getNewFavoriteID(UserID, this.restaurants[Index].id);
      }
    },
    async callAPIPostFavorite(UserID, RestaurantID) {
      axios.post('http://localhost:8000/api/v1/favorites/',
        {
          user_id: UserID,
          restaurant_id: RestaurantID
        }
      ).then(
        function (response) {
          if (response.data.errorcode) alert(response.data.message);
        }
      ).catch(
        function (error) {
          alert(error);
        }
      );
    },
    async callAPIDeleteFavorite(FavoriteID) {
      axios.request({
        method: 'delete',
        url: 'http://localhost:8000/api/v1/favorites/delete',
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
    },
    async callAPIGetFavorite(UserID, RestaurantID) {
      const response = await axios.get(
        'http://localhost:8000/api/v1/favorites/?user_id=' + UserID + '&restaurant_id=' + RestaurantID
      );
      this.favorites = response.data.favorites;
    },
  },
  props: ["userinfo", "csrf"]
}
</script>

<style scoped>
.container {
  margin: 40px 80px 80px 80px;
}
.restaurants {
  width: 100%;
}
.list {
  display: flex;
}
.flex-row {
  flex-direction: row;
  flex-wrap: wrap;
}
.flex-row div {
  margin-right : 10px;
  margin-bottom: 10px;
}
.restaurant-card {
  width: 300px;
  border-radius: 5px;
  box-shadow: 0 0 5px #000;
  overflow: hidden;
}
.restaurant-card-img {
  width: inherit;
  height: 160px;
}
.restaurant-card-img img{
  width: 100%;
  height: inherit;
  object-fit: cover;
}
.restaurant-card-content {
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
.restaurant-card-footer {
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