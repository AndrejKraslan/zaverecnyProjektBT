<template>
  <div class="modal fade show d-block" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Speaker</h5>
          <button type="button" class="btn-close" @click="$emit('close')"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submitForm">
            <div class="mb-3">
              <label for="speakerName" class="form-label">Name</label>
              <input type="text" class="form-control" id="speakerName" v-model="formData.Name" required>
            </div>
            <div class="mb-3">
              <label for="speakerDescriptionShort" class="form-label">Short Description</label>
              <textarea class="form-control" id="speakerDescriptionShort" v-model="formData.Description_Short" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <label for="speakerDescriptionLong" class="form-label">Long Description</label>
              <textarea class="form-control" id="speakerDescriptionLong" v-model="formData.Description_Long" rows="6" required></textarea>
            </div>
            <div class="mb-3">
              <label for="speakerImage" class="form-label">Image URL</label>
              <input type="text" class="form-control" id="speakerImage" v-model="formData.Image" required>
            </div>
            <div class="mb-3">
              <label for="speakerFacebook" class="form-label">Facebook</label>
              <input type="text" class="form-control" id="speakerFacebook" v-model="formData.Facebook">
            </div>
            <div class="mb-3">
              <label for="speakerInstagram" class="form-label">Instagram</label>
              <input type="text" class="form-control" id="speakerInstagram" v-model="formData.Instagram">
            </div>
            <div class="mb-3">
              <label for="speakerTwitter" class="form-label">Twitter</label>
              <input type="text" class="form-control" id="speakerTwitter" v-model="formData.Twitter">
            </div>
            <div class="mb-3">
              <label for="speakerWeb" class="form-label">Website</label>
              <input type="text" class="form-control" id="speakerWeb" v-model="formData.Web">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
          </form>
        </div>
      </div>
    </div>
    <div class="modal-backdrop fade show"></div>
  </div>
</template>

<script setup>
import { ref, watch, defineEmits, defineProps } from 'vue';

const props = defineProps({
  speaker: Object
});

const emit = defineEmits(['close', 'save']);

const formData = ref({ ...props.speaker });

watch(() => props.speaker, (newVal) => {
  formData.value = { ...newVal };
});

const submitForm = () => {
  const updatedSpeaker = { ...formData.value };
  console.log('Form Data to Save:', updatedSpeaker); // Log form data before emitting
  emit('save', updatedSpeaker);
};
</script>

<style scoped>
.modal {
  display: block;
}

.modal-backdrop {
  z-index: 1040;
}

.modal-dialog {
  z-index: 1050;
}
</style>
