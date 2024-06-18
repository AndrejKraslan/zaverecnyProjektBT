<template>
  <div class="modal">
    <div class="modal-content">
      <span class="close" @click="$emit('close')">&times;</span>
      <h2>Add Stage</h2>
      <form @submit.prevent="submitForm">
        <div>
          <label for="name">Name:</label>
          <input type="text" id="name" v-model="stage.Name" required>
        </div>
        <div>
          <label for="date">Date:</label>
          <input type="date" id="date" v-model="stage.Date" required>
        </div>
        <div>
          <label for="room">Room:</label>
          <input type="text" id="room" v-model="stage.Room" required>
        </div>
        <button type="submit">Add Stage</button>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      stage: {
        Name: '',
        Date: '',
        Room: ''
      }
    };
  },
  methods: {
    submitForm() {
      const payload = {
        name: this.stage.Name,
        date: this.stage.Date + ' 00:00:00', // Adding time to the date
        room: this.stage.Room
      };
      this.$emit('add-stage', payload);
      this.stage.Name = '';
      this.stage.Date = '';
      this.stage.Room = '';
      this.$emit('close');
    }
  }
};
</script>

<style scoped>
.modal {
  display: block;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0, 0, 0);
  background-color: rgba(0, 0, 0, 0.4);
  padding-top: 60px;
}

.modal-content {
  background-color: #fefefe;
  margin: 5% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}
</style>
