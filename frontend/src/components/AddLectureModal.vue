<template>
  <div class="modal fade show d-block" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Lecture</h5>
          <button type="button" class="close" @click="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="save">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" v-model="lecture.Name" class="form-control" id="name" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea v-model="lecture.Description" class="form-control" id="description" required></textarea>
            </div>
            <div class="form-group">
              <label for="image">Image</label>
              <input type="text" v-model="lecture.Image" class="form-control" id="image">
            </div>
            <div class="form-group">
              <label for="capacity">Capacity</label>
              <input type="number" v-model="lecture.Capacity" class="form-control" id="capacity" required>
            </div>
            <div class="form-group">
              <label for="maxCapacity">Max Capacity</label>
              <input type="number" v-model="lecture.MaxCapacity" class="form-control" id="maxCapacity" required>
            </div>
            <div class="form-group">
              <label for="start">Start</label>
              <input type="datetime-local" v-model="lecture.Start" class="form-control" id="start" required>
            </div>
            <div class="form-group">
              <label for="end">End</label>
              <input type="datetime-local" v-model="lecture.End" class="form-control" id="end" required>
            </div>
            <div class="form-group">
              <label for="stage">Stage</label>
              <select v-model="lecture.StageID" class="form-control" id="stage" required>
                <option v-for="stage in stages" :key="stage.ID" :value="stage.ID">{{ stage.Name }}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="speaker">Speaker</label>
              <select v-model="lecture.SpeakerID" class="form-control" id="speaker">
                <option v-for="speaker in speakers" :key="speaker.ID" :value="speaker.ID">{{ speaker.Name }}</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    stages: Array,
    speakers: Array,
  },
  data() {
    return {
      lecture: {
        Name: '',
        Description: '',
        Image: '',
        Capacity: null,
        MaxCapacity: null,
        Start: '',
        End: '',
        StageID: null,
        SpeakerID: null,
      },
    };
  },
  methods: {
    save() {
      const newLecture = {
        Name: this.lecture.Name,
        Description: this.lecture.Description,
        Image: this.lecture.Image,
        Capacity: this.lecture.Capacity,
        MaxCapacity: this.lecture.MaxCapacity,
        Start: this.lecture.Start,
        End: this.lecture.End,
        StageID: this.lecture.StageID,
        SpeakerID: this.lecture.SpeakerID,
      };
      this.$emit('add-lecture', newLecture);
    },
    close() {
      this.$emit('close');
    },
  },
};
</script>

<style scoped>
.modal {
  display: block;
  background: rgba(0, 0, 0, 0.6);
}
.modal-dialog {
  max-width: 800px;
  margin: 1.75rem auto;
}
.modal-header {
  background-color: #00535D;
  color: white;
}
.modal-title {
  font-size: 1.5rem;
}
.modal-body {
  padding: 20px;
}
.modal-footer {
  display: flex;
  justify-content: flex-end;
  padding: 10px 20px;
}
</style>
