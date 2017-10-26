<template>

<v-layout justify-center>
  <v-card v-if="!hasPhoto" :class="errors.has('photo') ? 'error':''">
    <v-card-text>
      <vue-clip
        :options="photo_upload_options"
        :on-added-file="onAddPhoto"
        class="uploader"
      >
        <template slot="clip-uploader-action">
          <div class="uploader-action dz-message">
            <v-icon>cloud_upload</v-icon>
            &nbsp; Please upload a recent photo
          </div>
        </template>
      </vue-clip>
    </v-card-text>
  </v-card>

  <v-card
    v-if="hasPhoto"
    style="width:200px"
    class="elevation-8"
  >
    <v-card-media
      :src="photo.dataUrl"
      height="200px"
    >
    </v-card-media>
    <v-card-text>
      <v-progress-linear
        color="primary"
        :size="80" :width="2"
        v-model="photo.progress"
        v-if="photo.progress < 100"
      ></v-progress-linear>
      <v-btn block
        color="primary"
        v-if="photo.status == 'success'"
        @click="onDropPhoto"
      >
        Remove
        <v-icon dark right>close</v-icon>
      </v-btn>
    </v-card-text>
  </v-card>
</v-layout>

</template>

<script>
export default {

  props: {
    url: {
      accept: String,
      required: true,
    }
  },

  data() {
    return {
      photo: null,
      photo_upload_options: {
        url: this.$props.url,
        acceptedFiles: 'image/jpeg,image/png,image/gif,image/tiff',
        uploadMultiple: false,
        maxFiles: 1,
      },

    }
  },

  computed: {

    hasPhoto() {
      return this.photo && this.photo.status !== 'error'
    },

  },

  methods: {

    onAddPhoto(file) {
      this.errors.remove('photo')
      this.photo = file
    },
    onDropPhoto() {
      axios.post('/api/drop', this.photo.xhrResponse)
      this.photo = null
    },
  }

}
</script>
