<template>
  <div class="modal" tabindex="-1" role="dialog" :class="{ show: dialog }" style="display: block;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Lecture</h5>
          <button type="button" class="close" @click="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="lecture-name">Name</label>
              <input type="text" class="form-control" id="lecture-name" v-model="editedLecture.Name">
            </div>
            <div class="form-group">
              <label for="lecture-start">Start</label>
              <input type="datetime-local" class="form-control" id="lecture-start" v-model="editedLecture.Start">
            </div>
            <div class="form-group">
              <label for="lecture-end">End</label>
              <input type="datetime-local" class="form-control" id="lecture-end" v-model="editedLecture.End">
            </div>
            <div class="form-group">
              <label for="lecture-stage">Stage</label>
              <select class="form-control" id="lecture-stage" v-model="editedLecture.StageID">
                <option v-for="stage in stages" :key="stage.ID" :value="stage.ID">
                  {{ stage.Name }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label for="lecture-speaker">Speaker</label>
              <select class="form-control" id="lecture-speaker" v-model="editedLecture.SpeakerID">
                <option v-for="speaker in speakers" :key="speaker.ID" :value="speaker.ID">
                  {{ speaker.Name }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label for="lecture-description">Description</label>
              <textarea class="form-control" id="lecture-description" v-model="editedLecture.Description"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="close">Cancel</button>
          <button type="button" class="btn btn-primary" @click="save">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EditLectureModal',
  props: {
    dialog: Boolean,
    lecture: Object,
    speakers: Array,
    stages: Array
  },
  data() {
    return {
      editedLecture: {...this.lecture}
    }
  },
  watch: {
    lecture: {
      handler() {
        this.editedLecture = {...this.lecture}
      },
      deep: true
    }
  },
  methods: {
    updateDialog(value) {
      this.$emit('update:dialog', value);
    },
    close() {
      this.$emit('close')
    },
    save() {
      this.$emit('edit-lecture', this.editedLecture)
    }
  }
}
</script>

<style scoped>
.modal.show {
  display: block;
}
</style>
