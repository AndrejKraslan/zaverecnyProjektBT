<template>
  <div class="slideshow">
    <div class="slides" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
      <div class="slide" v-for="(slide, index) in slides" :key="index">
        <div class="content">
          <h2>{{ slide.title }}</h2>
          <h1>{{ slide.subtitle }}</h1>
          <div class="buttons">
            <button @click="slide.action1">{{ slide.action1Text }}</button>
            <button @click="slide.action2">{{ slide.action2Text }}</button>
          </div>
        </div>
      </div>
    </div>
    <button class="prev" @click="prevSlide">❮</button>
    <button class="next" @click="nextSlide">❯</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentIndex: 0,
      slides: [
        {
          title: '14 - 26 DECEMBER 2016, NEW YORK',
          subtitle: 'MATERIAL DESIGNER CONFERENCE',
          action1Text: 'REGISTER NOW',
          action1: this.registerNow,
          action2Text: 'LEARN MORE',
          action2: this.learnMore
        },
        {
          title: 'Slide 2 Title',
          subtitle: 'Slide 2 Subtitle',
          action1Text: 'ACTION 1',
          action1: this.registerNow,
          action2Text: 'ACTION 2',
          action2: this.learnMore
        },
        {
          title: 'Slide 3 Title',
          subtitle: 'Slide 3 Subtitle',
          action1Text: 'ACTION 1',
          action1: this.registerNow,
          action2Text: 'ACTION 2',
          action2: this.learnMore
        }
      ]
    };
  },
  methods: {
    prevSlide() {
      this.currentIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length;
    },
    nextSlide() {
      this.currentIndex = (this.currentIndex + 1) % this.slides.length;
    },
    registerNow() {
      alert('Register Now clicked!');
    },
    learnMore() {
      alert('Learn More clicked!');
    }
  }
};
</script>

<style scoped>
.slideshow {
  position: relative;
  width: 100%;
  height: 400px;
  overflow: hidden;
  margin: 0;
  background: #333;
  color: #fff;
  text-align: center;
}

.slides {
  display: flex;
  transition: transform 0.5s ease;
}

.slide {
  min-width: 100%;
  box-sizing: border-box;
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
  padding: 20px;
}

.content {
  max-width: 800px;
}

h2 {
  font-size: 1.5rem;
  margin: 0;
}

h1 {
  font-size: 3rem;
  margin: 0.5rem 0;
}

.buttons {
  margin-top: 20px;
}

button {
  padding: 10px 20px;
  margin: 0 10px;
  background: none;
  border: 2px solid #fff;
  color: #fff;
  cursor: pointer;
}

button:hover {
  background: #fff;
  color: #333;
}

.prev, .next {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: none;
  border: none;
  font-size: 2rem;
  color: #fff;
  cursor: pointer;
}

.prev {
  left: 10px;
}

.next {
  right: 10px;
}
</style>
