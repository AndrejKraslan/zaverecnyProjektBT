<template>
  <div class="container mt-5">
    <h2>Gallery</h2>
    <div class="row">
      <div class="col-md-3">
        <h3>Years</h3>
        <ul class="list-group">
          <li
              v-for="year in years"
              :key="year.year_id"
              class="list-group-item"
              :class="{ active: year.year === selectedYear }"
              @click="selectYear(year.year)"
          >
            {{ year.year }}
          </li>
        </ul>
      </div>
      <div class="col-md-9">
        <h3>Images from {{ selectedYear }}</h3>
        <div class="row">
          <div v-for="image in images" :key="image.image_id" class="col-md-4 mb-3">
            <img :src="getImageUrl(image.image)" alt="Gallery image" class="img-fluid" @click="showImage(image)">
            <button v-if="isAdmin" class="btn btn-danger btn-sm mt-2" @click="deleteImage(image.image_id)">Delete</button>
          </div>
        </div>
        <button v-if="isAdmin" class="btn btn-primary mt-3" @click="showAddImageForm">Add Image</button>
        <div v-if="showForm" class="mt-3">
          <h3>Add Image</h3>
          <form @submit.prevent="addImage">
            <div class="mb-3">
              <label for="image" class="form-label">Choose Image</label>
              <input type="file" class="form-control" id="image" @change="onFileChange" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <b-modal v-model="showModal" size="lg" centered>
      <template #modal-header>
        <h5 class="modal-title">Image</h5>
        <b-button variant="close" @click="showModal = false" aria-label="Close"></b-button>
      </template>
      <div class="text-center">
        <img :src="modalImageSrc" alt="Gallery image" class="img-fluid">
      </div>
    </b-modal>
  </div>
</template>



<script>
import axios from '@/plugins/axios.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import { BModal, BButton } from 'bootstrap-vue-3';

export default {
  name: 'Gallery',
  components: {
    BModal,
    BButton
  },
  data() {
    return {
      years: [],
      images: [],
      selectedYear: null,
      showForm: false,
      newImage: null,
      newImageYearId: null,
      showModal: false,
      modalImageSrc: '',
      isAdmin: false,
      isLoggedIn: false
    };
  },
  methods: {
    async fetchYears() {
      try {
        const response = await axios.get('http://localhost:8888/zaverecnyProjektBT/backend/public/api/years');
        this.years = response.data;
        console.log("Years fetched:", this.years);
      } catch (error) {
        console.error('Error fetching years:', error);
      }
    },
    async fetchImages(year_id) {
      try {
        const response = await axios.get(`http://localhost:8888/zaverecnyProjektBT/backend/public/api/images/${year_id}`);
        this.images = response.data;
        console.log("Images fetched for year_id", year_id, ":", this.images);
      } catch (error) {
        console.error('Error fetching images:', error);
      }
    },
    selectYear(year) {
      this.selectedYear = year;
      const selectedYearData = this.years.find(y => y.year === year);
      if (selectedYearData) {
        this.newImageYearId = selectedYearData.year_id;
        this.fetchImages(selectedYearData.year_id);
      }
    },
    getImageUrl(imagePath) {
      return `http://localhost:8888/zaverecnyProjektBT/backend/public/storage/${imagePath}`;
    },
    onFileChange(e) {
      this.newImage = e.target.files[0];
    },
    async addImage() {
      try {
        const formData = new FormData();
        formData.append('image', this.newImage);
        formData.append('year_id', this.newImageYearId);

        await axios.post('http://localhost:8888/zaverecnyProjektBT/backend/public/api/create_image', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        this.newImage = null;
        this.fetchImages(this.newImageYearId);
        this.showForm = false;
      } catch (error) {
        console.error('Error adding image:', error);
      }
    },
    async deleteImage(id) {
      try {
        await axios.delete(`http://localhost:8888/zaverecnyProjektBT/backend/public/api/delete_image/${id}`);
        this.fetchImages(this.newImageYearId);
      } catch (error) {
        console.error('Error deleting image:', error);
      }
    },
    showAddImageForm() {
      this.showForm = true;
    },
    showImage(image) {
      this.modalImageSrc = this.getImageUrl(image.image);
      this.showModal = true;
    },
    checkAdminStatus() {
      axios
          .get('/user')
          .then((response) => {
            this.isAdmin = response.data.is_admin === 1;
            this.isLoggedIn = true;
          })
          .catch((error) => {
            console.error('Error checking admin status:', error);
          });
    }
  },
  created() {
    this.fetchYears();
    this.checkAdminStatus();
  }
};
</script>


<style scoped>
.list-group-item {
  cursor: pointer;
}

.list-group-item.active {
  background-color: #8666f6;
  color: white;
}

.img-fluid {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  cursor: pointer;
}

.btn-close {
  background-color: #ccc;
}
</style>

