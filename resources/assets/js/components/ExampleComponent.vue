<template>
<v-app>
<v-container fluid>
<v-layout row wrap justify-center>
<v-flex xs12 md8 lg6 xl4>

<v-card>
  <v-card-title class="pb-0">
    <h3 class="headline mb-0 primary--text">
      Example Avatar Uploader
    </h3>
  </v-card-title>
  <v-card-text>

  <vk-avatar-uploader
    url="/api/upload"
  ></vk-avatar-uploader>

  </v-card-text>
</v-card>


<v-card>
  <v-card-title class="pb-0">
    <h3 class="headline mb-0 primary--text">
      Example Document Uploader
    </h3>
  </v-card-title>
  <v-card-text>

  <vk-document-uploader
    url="/api/upload"
  ></vk-document-uploader>

  </v-card-text>
</v-card>





</v-flex>
</v-layout>
</v-container>
</v-app>
</template>

<script>
export default {
  data() {
    return {
      form: {
        photo: null
      },
      photo_upload_options: {
        url: '/api/upload',
        acceptedFiles: 'image/*',
        uploadMultiple: false,
        maxFiles: 1,
      },

    }
  },

  created() {
    console.log('created')
  },

  computed: {

    hasPhoto() {
      return this.form.photo && this.form.photo.status !== 'error'
    },

  },

  methods: {

    onAddPhoto(file) {
      this.errors.remove('photo')
      this.form.photo = file
    },
    onDropPhoto() {
      axios.post('/api/drop', this.form.photo.xhrResponse)
      this.form.photo = null
    },
  }

}
</script>
