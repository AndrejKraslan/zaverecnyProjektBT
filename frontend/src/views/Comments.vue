<template>
  <div class="container mt-5">
    <h2 v-if="isAdmin">Add Comment</h2>
    <form v-if="isAdmin" @submit.prevent="addComment">
      <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" v-model="newComment.name" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" v-model="newComment.description" required></textarea>
      </div>
      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" @change="onFileChange">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <div class="mt-5">
      <h2>Comments</h2>
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="comment in comments" :key="comment.ID">
          <div @click="showModal(comment)" style="cursor: pointer;">
            <img v-if="comment.Image" :src="comment.Image" alt="Comment image" class="comment-image">
            <div class="ms-3">
              <h5>{{ comment.Name }}</h5>
              <p>{{ comment.Description }}</p>
              <small class="text-muted">{{ comment.CreatedAt }}</small>
            </div>
          </div>
          <button v-if="isAdmin" @click.stop="deleteComment(comment.ID)" class="btn btn-danger btn-sm">Delete</button>
        </li>
      </ul>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="commentModalLabel">{{ modalComment.Name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img v-if="modalComment.Image" :src="modalComment.Image" alt="Comment image" class="img-fluid mb-3">
            <p>{{ modalComment.Description }}</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from '@/plugins/axios.js';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';

axios.defaults.baseURL = 'http://localhost:8888/zaverecnyProjektBT/backend/public/api';

export default {
  name: "Comments",
  data() {
    return {
      newComment: {
        name: '',
        description: '',
        image: null
      },
      comments: [],
      modalComment: {
        name: '',
        description: '',
        image: null
      },
      isAdmin: false,
    };
  },
  methods: {
    async fetchComments() {
      try {
        const response = await axios.get('/comments');
        this.comments = response.data;
      } catch (error) {
        console.error('Error fetching comments:', error);
      }
    },
    onFileChange(event) {
      this.newComment.image = event.target.files[0];
    },
    async addComment() {
      try {
        const formData = new FormData();
        formData.append('name', this.newComment.name);
        formData.append('description', this.newComment.description);
        formData.append('image', this.newComment.image);

        await axios.post('/create_comment', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });

        this.newComment.name = '';
        this.newComment.description = '';
        this.newComment.image = null;
        this.fetchComments();
      } catch (error) {
        console.error('Error adding comment:', error);
      }
    },
    async deleteComment(commentId) {
      try {
        await axios.delete(`/delete_comment/${commentId}`);
        this.fetchComments(); // Refresh the comments after deletion
      } catch (error) {
        console.error('Error deleting comment:', error);
        if (error.response) {
          // Server responded with a status code different from 2xx
          console.error('Response data:', error.response.data);
          console.error('Response status:', error.response.status);
          console.error('Response headers:', error.response.headers);
        } else if (error.request) {
          // Request was made but no response was received
          console.error('Request data:', error.request);
        } else {
          // Something happened in setting up the request
          console.error('Error message:', error.message);
        }
      }
    },
    showModal(comment) {
      this.modalComment = comment;
      const modal = new bootstrap.Modal(document.getElementById('commentModal'));
      modal.show();
    },
    async checkAdminStatus() {
      try {
        const response = await axios.get('/user');
        this.isAdmin = response.data.is_admin === 1;
      } catch (error) {
        console.error('Error checking admin status:', error);
      }
    }
  },
  created() {
    this.fetchComments();
    this.checkAdminStatus();
  }
};
</script>
<style scoped>
.comment-image {
  width: 100px;
  height: 100px;
  object-fit: cover;
}
.list-group-item {
  background-color: #b3e0ff;
  display: flex;
  align-items: center;
}
</style>
