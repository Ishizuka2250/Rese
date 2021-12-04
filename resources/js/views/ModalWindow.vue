<template>
  <div class="modal-container">
    <div class="window">
      <p class="message">{{this.message}}</p>
      <div v-if="this.windowtype == 'OK'">
        <button class="button" v-on:click="modalAction">OK</button>
      </div>
      <div v-else-if="this.windowtype == 'YESNO'" class="yesno">
        <button class="button" v-on:click="modalAction(true)">OK</button>
        <button class="button" v-on:click="modalAction(false)">キャンセル</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      d: ''
    }
  },
  methods: {
    modalAction(value) {
      this.action();
      this.$emit('modal-action', value);
    }
  },
  props:["message", "windowtype", "action"]
}
</script>

<style scoped>
.modal-container {
  display: flex;
  justify-content: center;
  align-items: center;

  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(0, 0, 0, 0.5);
}
.window {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 400px;
  height: 200px;
  background: #FFF;
  padding: 30px;
  color: #000;
  border-radius: 5px;
  box-shadow: 2px 2px 5px #000;
}
.message {
  font-size: 24px;
  margin-bottom: 50px;
}
.button {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  background-color: #305dff;
  color: #FFF;
}
</style>