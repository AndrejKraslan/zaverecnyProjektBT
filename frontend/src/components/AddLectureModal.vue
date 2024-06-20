<template>
  <div class="modal" tabindex="-1" style="display: block;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Lecture</h5>
          <button type="button" class="btn-close" @click="$emit('close')"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitLecture">
            <div class="mb-3">
              <label for="lectureName" class="form-label">Name</label>
              <input type="text" class="form-control" id="lectureName" v-model="lecture.Name" required>
            </div>
            <div class="mb-3">
              <label for="lectureDescription" class="form-label">Description</label>
              <textarea class="form-control" id="lectureDescription" v-model="lecture.Description" required></textarea>
            </div>
            <div class="mb-3">
              <label for="lectureImage" class="form-label">Image</label>
              <input type="text" class="form-control" id="lectureImage" v-model="lecture.Image">
            </div>
            <div class="mb-3">
              <label for="lectureMaxCapacity" class="form-label">Max Capacity</label>
              <input type="number" class="form-control" id="lectureMaxCapacity" v-model="lecture.MaxCapacity" required>
            </div>
            <div class="mb-3">
              <label for="lectureStart" class="form-label">Start Time</label>
              <input type="time" class="form-control" id="lectureStart" v-model="lecture.Start" required>
            </div>
            <div class="mb-3">
              <label for="lectureEnd" class="form-label">End Time</label>
              <input type="time" class="form-control" id="lectureEnd" v-model="lecture.End" required>
            </div>
            <div class="mb-3">
              <label for="lectureStage" class="form-label">Stage</label>
              <select class="form-select" id="lectureStage" v-model="lecture.StageID" required>
                <option v-for="stage in stages" :key="stage.ID" :value="stage.ID">
                  {{ stage.Name }}
                </option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Lecture</button>
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
        Capacity: 0,
        MaxCapacity: 0,
        Start: '',
        End: '',
        StageID: null,
        SpeakerID: null
      }
    };
  },
  methods: {
    submitLecture() {
      this.$emit('add-lecture', this.lecture);
    }
  }
};
</script>

<style scoped>
.modal-backdrop {
  position: static;
}
</style>
