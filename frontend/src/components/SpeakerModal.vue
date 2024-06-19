<template>
  <div class="modal fade show" tabindex="-1" aria-labelledby="exampleModalLabel" aria-modal="true" role="dialog" style="display: block;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ speaker?.Name }}</h5>
          <button type="button" class="btn-close" aria-label="Close" @click="$emit('close')"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <img :src="getImageUrl(speaker?.Image)" class="img-fluid mb-3" :alt="speaker?.Name">
            </div>
            <div class="col-md-8">
              <h4>{{ speaker?.Name }}</h4>
              <p class="text-muted">{{ speaker?.company }}</p>
              <ul class="list-inline">
                <li class="list-inline-item"><a :href="speaker?.Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                <li class="list-inline-item"><a :href="speaker?.Twitter" target="_blank"><i class="fab fa-twitter"></i></a></li>
                <li class="list-inline-item"><a :href="speaker?.Instagram" target="_blank"><i class="fab fa-instagram"></i></a></li>
                <li class="list-inline-item"><a :href="speaker?.Web" target="_blank"><i class="fas fa-globe"></i></a></li>
              </ul>
              <p class="description-long">{{ speaker?.Description_Long }}</p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="$emit('close')">Zavrieť</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  speaker: {
    type: Object,
    default: null,
  },
});

const getImageUrl = (imagePath) => {
  return `http://localhost/zaverecnyProjektBT/backend/public/${imagePath}`;
};
</script>

<style scoped>
.modal {
  background: rgba(0, 0, 0, 0.5);
}

.modal-content {
  border-radius: 8px;
  overflow: hidden;
}

.modal-header {
  background-color: #f8f9fa;
}

.modal-body {
  background-color: #fff;
  max-height: 500px;
  overflow-y: auto;
}

.modal-footer {
  background-color: #f8f9fa;
}

.list-inline-item a {
  color: #7c4dff;
  font-size: 20px;
  margin-right: 10px;
  transition: color 0.3s;
}

.list-inline-item a:hover {
  color: #262626;
}

.img-fluid {
  max-height: 300px;
  object-fit: cover;
}

.description-long {
  white-space: normal;
  word-wrap: break-word;
}
</style>
