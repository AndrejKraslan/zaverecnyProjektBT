<template>
  <div class="modal">
    <h2>Add Speaker to Lecture</h2>
    <form @submit.prevent="submitForm">
      <div>
        <label for="speaker">Speaker</label>
        <select v-model="speakerLecture.speaker_id" required>
          <option v-for="speaker in speakers" :key="speaker.ID" :value="speaker.ID">{{ speaker.Name }}</option>
        </select>
      </div>
      <div>
        <label for="lecture">Lecture</label>
        <select v-model="speakerLecture.lecture_id" required>
          <option v-for="lecture in lectures" :key="lecture.ID" :value="lecture.ID">{{ lecture.Name }}</option>
        </select>
      </div>
      <button type="submit">Save</button>
      <button type="button" @click="$emit('close')">Cancel</button>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    speakers: Array,
    lectures: Array
  },
  data() {
    return {
      speakerLecture: {
        speaker_id: null,
        lecture_id: null
      }
    };
  },
  methods: {
    async submitForm() {
      try {
        const response = await fetch('http://localhost:8888/zaverecnyProjektBT/backend/public/api/register_lecture_speaker', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(this.speakerLecture)
        });

        if (!response.ok) {
          const errorText = await response.text();
          console.error('Failed to add speaker to lecture:', errorText);
          throw new Error('Failed to add speaker to lecture');
        }

        const result = await response.json();
        console.log('Speaker assigned to lecture successfully:', result);

        this.$emit('speaker-assigned', result);
        this.$emit('close'); // Close the modal after successful operation
      } catch (error) {
        console.error('Error assigning speaker to lecture:', error.message);
      }
    }
  }
};
</script>

<style scoped>
.modal {
  display: flex;
  justify-content: center;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  width: 500px;
  max-width: 90%;
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
}
</style>
